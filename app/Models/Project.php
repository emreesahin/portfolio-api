<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'url_github',
        'url_live',
        'gallery',
        'category_id',
    ];

    protected $casts = [
        'gallery' => 'array',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
