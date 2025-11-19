<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'student_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Role checking methods
    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isLecturer()
    {
        return $this->role === 'lecturer';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    // ADD THESE RELATIONSHIPS HERE:
    public function taughtSubjects()
    {
        return $this->hasMany(Subject::class, 'lecturer_id');
    }
    
    public function subjects()
{
    return $this->belongsToMany(Subject::class, 'subject_student', 'student_id', 'subject_id')
                ->withTimestamps();
}


    // PHP 7 COMPATIBLE VERSION:
    public function getRedirectRoute()
    {
        switch ($this->role) {
            case 'admin':
                return '/admin';
            case 'lecturer':
                return '/lecturer';
            case 'student':
                return '/student';
            default:
                return '/student';
        }
    }
}