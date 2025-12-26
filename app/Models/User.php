<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'profile_photo',
        'occupation',
        'bio',
        'phone',
        'address',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
            ->withPivot('status', 'progress', 'enrolled_at', 'completed_at')
            ->withTimestamps();
    }

    public function experiences()
    {
        return $this->hasMany(UserExperience::class)->orderBy('start_date', 'desc');
    }

    public function educations()
    {
        return $this->hasMany(UserEducation::class)->orderBy('start_date', 'desc');
    }

    public function hasPurchased($type, $id)
    {
        // Simple check for simulation or real orders
        return \App\Models\OrderItem::whereHas('order', function ($q) {
            $q->where('user_id', $this->id)->where('status', 'completed');
        })
            ->where($type . '_id', $id)
            ->exists();
    }

    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
