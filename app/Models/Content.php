<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_title',
        'home_subtitle',
        'projects_title',
        'projects_empty',
        'contact_title',
        'contact_text',
        'contact_button',
    ];
}
