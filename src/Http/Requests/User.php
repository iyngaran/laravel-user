<?php


namespace Iyngaran\LaravelUser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class User extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'role_ids' => 'required'

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required',
            'email.required' => 'The email field is required',
            'role_ids.required' => 'The roles field is required'
        ];
    }
}
