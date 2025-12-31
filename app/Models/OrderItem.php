<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'course_id',
        'material_id',
        'lecture_id',
        'quiz_id',
        'price',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
