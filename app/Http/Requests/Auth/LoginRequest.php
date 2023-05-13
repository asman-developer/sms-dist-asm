<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required|numeric|digits:11',
            'password' => 'required|string|min:6|max:100',
        ];
    }
}
