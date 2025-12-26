<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'short_description',
        'description',
        'price',
        'status',
        'is_free',
        'live_class_available',
        'zoom_meeting_id',
        'zoom_meeting_password',
        'zoom_meeting_link',
        'live_date',
        'live_time',
        'video_url',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_free' => 'boolean',
        'live_class_available' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->with(['user', 'replies', 'reactions'])->orderBy('created_at', 'desc');
    }
}
