<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'lecture_id',
        'parent_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with(['user', 'reactions'])->orderBy('created_at', 'asc');
    }

    public function reactions()
    {
        return $this->hasMany(CommentReaction::class);
    }

    public function isLikedBy($userId)
    {
        return $this->reactions()->where('user_id', $userId)->exists();
    }
}
