<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $id = $this->category?->id;

        return [
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:category,slug' . $id,
        ];
    }
}
