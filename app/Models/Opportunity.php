<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    protected $fillable = [
        'posted_by', 'title', 'description', 'skill_tags', 'deadline',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function poster()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function tagsArray(): array
    {
        return array_map(fn ($t) => strtolower(trim($t)), explode(',', $this->skill_tags));
    }
}
