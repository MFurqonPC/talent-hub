<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointHistory extends Model
{
    public $timestamps = false; // hanya pakai created_at manual

    protected $fillable = [
        'student_id',
        'source_type',
        'source_id',
        'points',
        'note',
    ];

    protected $attributes = [
        'created_at' => null,
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->created_at = now();
        });
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
