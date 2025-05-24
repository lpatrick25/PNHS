<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $primaryKey = 'user_id';

    public $fillable = [
        'username',
        'password',
        'role',
        'is_active',
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'user_id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'user_id', 'user_id');
    }

    public function principal()
    {
        return $this->hasOne(Principal::class, 'user_id', 'user_id');
    }
}
