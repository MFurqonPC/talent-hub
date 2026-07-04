<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardClaim extends Model
{
    protected $fillable = [
        'student_id', 'reward_id', 'status', 'claimed_at',
    ];

    protected $casts = [
        'claimed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
}
