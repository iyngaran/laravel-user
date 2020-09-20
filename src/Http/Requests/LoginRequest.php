<?php

namespace Iyngaran\LaravelUser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'email' => 'email|required',
            'password' => 'required',
            'device_name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'The email field is required',
            'password.required' => 'The password field is required',
            'device_name.required' => 'The device_name field is required'
        ];
    }
}
