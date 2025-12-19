<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'short_description',
        'duration',
        'instructions',
        'lecture_id',
        'is_free',
        'price',
    ];

    protected $casts = [
        'duration' => 'integer',
        'is_free' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }
}
