<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'student_id', 'title', 'category', 'description', 'file_path', 'link',
        'status', 'point_value', 'reviewed_by', 'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    // Mapping poin default sesuai tabel aturan poin di soal
    public const DEFAULT_POINTS = [
        'personal' => 2,
        'freelance' => 5,
        'industri' => 8,
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function defaultPoint(): int
    {
        return self::DEFAULT_POINTS[$this->category] ?? 0;
    }
}
