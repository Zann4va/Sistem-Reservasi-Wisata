<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'users';
    protected $fillable = [
        'username',
        'email',
        'password',
        'No_Handphone',
        'role',
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}