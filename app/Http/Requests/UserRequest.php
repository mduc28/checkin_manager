<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    public function rules(): array
    {
        $rules = [
            'name'  => 'required|max:255|min:6',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'phone' => 'required|regex:/^(0)[0-9]{9,10}$/',
            'role'  => 'required|numeric',
        ];

        if ($this->isMethod('post')) {
            $rules['password']    = 'required|min:6|required_with:re_password|same:re_password';
            $rules['re_password'] = 'min:6|required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => ':Attribute must be filled',
            'max'      => ':Attribute is too long(max: 255 characters)',
            'min'      => ':Attribute is too short(min: 6 characters)',
            'numeric'  => ':Attribute must be number',
            'same'     => 'Password is not same as re-password',
            'unique'   => ':Attribute already existed!',
            'email'    => 'Please enter an email',
            'regex'    => 'Phone number is invalid'
        ];
    }
}
