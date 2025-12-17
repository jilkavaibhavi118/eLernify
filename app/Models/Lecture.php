<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'price',
        'status',
        'live_class_available',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'live_class_available' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
