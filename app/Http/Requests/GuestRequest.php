<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestRequest extends FormRequest
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
            'name'     => ['required'],
            'phone'    => ['required', 'regex:/^(0)[0-9]{9,10}$/'],
            'address'  => ['required'],
            'birthday' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'required'     => ':Attribute must be filled',
            'phone.unique' => 'Phone number already existed',
            'phone.regex'  => 'Phone number is invalid',
        ];
    }
}
