<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'name'         => ['required'],
            'address'      => ['required'],
            'email'        => 'email|required|unique:App\Models\Member,email,' . $this->id,
            'phone'        => ['required', 'regex:/^(0)[0-9]{9,10}$/', 'unique:members,phone,' . $this->id],
            'birthday'     => ['required'],
            'expired_date' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'required'     => ':Attribute must be filled',
            'email.unique' => 'Email already existed',
            'phone.unique' => 'Phone number already existed',
            'phone.regex'  => 'Phone number is invalid',
            'email'        => 'Email is invalid',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data        = $validator->getData();
            $datePresent = Carbon::now()->toDateString();
            $expiredDate = $data['expired_date'];

            if (strtotime($expiredDate) <= strtotime($datePresent)) {
                $validator->errors()->add('expired_date', 'The expiration date must be greater than the current date');
            }
        });
    }
}
