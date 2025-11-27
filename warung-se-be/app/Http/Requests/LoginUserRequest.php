<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email_user' => 'required|email',
            'password' => 'required|string|min:4',
        ];
    }

    public function messages(): array
    {
        return [
            'email_user.required' => 'Email harus diisi',
            'email_user.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
        ];
    }
}
