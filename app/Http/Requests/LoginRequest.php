<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'login' => ['required', 'string', 'max:32'],
            'password' => ['required', 'string', 'max:255', 'min:6'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
