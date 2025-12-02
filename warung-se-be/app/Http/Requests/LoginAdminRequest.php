<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email_admin' => 'required|email',
            'password' => 'required|string|min:4',
        ];
    }

    public function messages(): array
    {
        return [
            'email_admin.required' => 'Email admin harus diisi',
            'email_admin.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
        ];
    }
}
