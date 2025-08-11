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
        return [
            'title' => 'required|string|max:200',
            'summary' => 'nullable|string|max:500',
            'body' => 'nullable|string',
            'url_github' => 'nullable|url|max:255',
            'url_live' => 'nullable|url|max:255',
            'featured' => 'boolean',
            'started_at' => 'nullable|date',
            'ended_at' => 'nullable|date|after_or_equal:started_at',
        ];
    }
}
