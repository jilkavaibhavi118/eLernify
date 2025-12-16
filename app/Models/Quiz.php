<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'title',
        'duration',
        'instructions',
        'lecture_id',
    ];

    protected $casts = [
        'duration' => 'integer',
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }
}
