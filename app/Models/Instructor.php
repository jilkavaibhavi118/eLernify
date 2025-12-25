<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'bio', 'image', 'status',
        'designation', 'specialty', 'linkedin_url', 'twitter_url', 'github_url', 'instagram_url', 'website_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
