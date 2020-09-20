<?php


namespace Iyngaran\LaravelUser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRole extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required'
        ];
    }
}
