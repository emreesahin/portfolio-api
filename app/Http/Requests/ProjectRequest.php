<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


 public function rules(): array
{
    $projectId = $this->project?->id;

    return [
        'title' => 'required|string|min:3|max:200',
        'slug' => 'required|string|max:255|unique:projects,slug,' . $projectId,
        'summary' => 'nullable|string|min:10|max:500',
        'body' => 'nullable|string',
        'url_github' => 'nullable|url|max:255',
        'url_live' => 'nullable|url|max:255',
        'featured' => 'boolean',
        'started_at' => 'nullable|date',
        'ended_at' => 'nullable|date|after_or_equal:started_at',
        'category_id' => 'nullable|exists:categories,id'
    ];
}

}
