<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact_contents';
    
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
