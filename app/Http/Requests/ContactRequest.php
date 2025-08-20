<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Models\Contact;

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
