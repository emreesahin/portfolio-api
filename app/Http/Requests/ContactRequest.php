<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:150',
            'email' => 'required|string|email|max:150',
            'message' => 'required|string|min:10',
        ];
    }
}
