<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required',
            'remember' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':Attribute must be filled',
            'email'    => ':Attribute must be email',
        ];
    }
}
