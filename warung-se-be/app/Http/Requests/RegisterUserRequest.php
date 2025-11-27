<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email_user' => 'required|email|unique:user,email_user',
            'nama_user' => 'required|string|max:255',
            'no_telp' => 'required|numeric|digits_between:10,15',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'email_user.required' => 'Email harus diisi',
            'email_user.email' => 'Format email tidak valid',
            'email_user.unique' => 'Email sudah terdaftar',
            'nama_user.required' => 'Nama harus diisi',
            'no_telp.required' => 'Nomor telepon harus diisi',
            'no_telp.numeric' => 'Nomor telepon harus berupa angka',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ];
    }
}
