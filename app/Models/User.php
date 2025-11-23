<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'settings' => 'array',
        'email_verified_at' => 'datetime', 
    ];


    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
}