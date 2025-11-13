<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'avatar',
        'bio',
        'skills',
    ];

    protected $casts = [
        'bio' => 'array',
        'skills' => 'array',
    ];
}
