<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $guard_name = 'web';

    protected $fillable = [
    'name',
    'email',
    'password',
    'title',
    'bio',
    'github_url',
    'linkedin_url',
    'twitter_url',
];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
