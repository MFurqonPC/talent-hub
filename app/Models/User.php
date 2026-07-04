<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\StudentProfile;
use App\Models\Certificate;
use App\Models\Portfolio;
use App\Models\PointHistory;
use App\Models\Skill;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'points',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function skills()
    {
        return $this->hasMany(Skill::class, 'student_id');
    }


    public function profile()
    {
        return $this->hasOne(StudentProfile::class);
    }


    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'student_id');
    }


    public function portfolios()
    {
        return $this->hasMany(Portfolio::class, 'student_id');
    }


    public function pointHistories()
    {
        return $this->hasMany(PointHistory::class, 'student_id');
    }


    public function scopeMahasiswa($query)
    {
        return $query->where('role', 'mahasiswa');
    }


    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}