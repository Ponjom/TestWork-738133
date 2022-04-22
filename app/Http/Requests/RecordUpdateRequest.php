<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
