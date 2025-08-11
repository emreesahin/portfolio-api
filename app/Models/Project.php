<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Project extends Model implements HasMedia
{

    use HasFactory, HasSlug, InteractsWithMedia;

    protected $fillable = [
        'title',
        'summary',
        'body',
        'url_github',
        'url_live',
        'featured',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];


    public function getSlugOptions(): SlugOptions {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollection(): void {

        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('gallery');

    }

}
