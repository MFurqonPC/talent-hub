<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'student_id',
        'skill_name',
        'level',
        'evidence_file',
        'status',
        'point_value',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Scope bantu untuk query di controller admin
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
