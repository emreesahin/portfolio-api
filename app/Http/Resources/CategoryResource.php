<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,

            'projects' => $this->whenLoaded('projects', function () {
                return ProjectResource::collection($this->projects);
            }),

            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
