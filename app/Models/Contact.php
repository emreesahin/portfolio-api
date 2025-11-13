<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'socials',
        'form',
    ];

    protected $casts = [
        'socials' => 'array',
        'form' => 'array',
    ];
}
