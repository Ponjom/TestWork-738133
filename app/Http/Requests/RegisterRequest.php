<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'login' => ['required', 'string', 'max:32', 'unique:users'],
            'password' => ['required', 'string', 'max:255', 'min:6'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
