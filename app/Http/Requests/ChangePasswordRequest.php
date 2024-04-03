<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password'    => 'required|min:6|required_with:re_password|same:re_password',
            're_password' => 'required',
        ];

        if ($this->request->has('current_password')) {
            $rules['current_password'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => ':Attribute must be filled',
            'min'      => 'Password is too short(min 6 charaters)',
            'same'     => 'Your re-password is not same as new password',
        ];
    }
}
