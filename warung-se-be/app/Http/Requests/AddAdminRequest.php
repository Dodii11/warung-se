<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('superadmin')->check();
    }

    public function rules(): array
    {
        return [
            'email_admin' => 'required|email|unique:admin,email_admin',
            'nama_admin' => 'required|string|max:255',
            'no_telp' => 'required|numeric|digits_between:10,15',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'email_admin.required' => 'Email admin harus diisi',
            'email_admin.unique' => 'Email admin sudah terdaftar',
            'nama_admin.required' => 'Nama admin harus diisi',
            'no_telp.required' => 'Nomor telepon harus diisi',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ];
    }
}
