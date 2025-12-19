<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'title',
        'short_description',
        'description',
        'file_path',
        'video_path',
        'lecture_id',
        'content_url',
        'is_free',
        'price',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
