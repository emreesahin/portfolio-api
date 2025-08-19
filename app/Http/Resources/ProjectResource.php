<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'body' => $this->body,
            'url'=>[
                'github' => $this->url_github,
                'live' => $this->url_live,
            ],
              'category' => $this->whenLoaded('category', function () {
            return [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ];
        }),
            'featured'=>$this->featured,
            'started_at'=>optional($this->started_at)->toDateString(),
            'ended_at'=>optional($this->ended_at)->toDateString(),
            'cover'=>$this->getFirstMediaUrl('cover') ?: null,
            'gallery' => $this->getMedia('gallery')->map(function($media) {
            return [
                'url' => $media->getUrl(),
                'name' => $media->file_name,
                'size' => $media->size,
            ];
        }),

            'created_at'=>$this->created_at?->toIso8601String(),
        ];
    }
}
