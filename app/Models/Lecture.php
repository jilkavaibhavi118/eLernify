<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = [
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
}
