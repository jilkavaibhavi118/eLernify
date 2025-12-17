<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'status',
        'image',
        'duration',
        'instructor_id',
        'category_id'
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
