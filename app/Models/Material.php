<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'lecture_id',
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
