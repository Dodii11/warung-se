<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginSuperAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email_super' => 'required|email',
            'password' => 'required|string|min:4',
        ];
    }

    public function messages(): array
    {
        return [
            'email_super.required' => 'Email super admin harus diisi',
            'email_super.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
        ];
    }
}
