<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Responses\ApiResponse;
use Illuminate\Container\Attributes\Auth;


class AuthController extends Controller
{
   public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $email = $request->email;
    $password = $request->password;

    // CARI DI TIGA TABEL BERDASARKAN KOLOM EMAIL MASING-MASING
    $user = \App\Models\User::where('email_user', $email)->first();
    $admin = \App\Models\Admin::where('email_admin', $email)->first();
    $super = \App\Models\SuperAdmin::where('email_super', $email)->first();

    // Tentukan role
    if ($user) {
        $account = $user;
        $role = 'user';
    } elseif ($admin) {
        $account = $admin;
        $role = 'admin';
    } elseif ($super) {
        $account = $super;
        $role = 'superadmin';
    } else {
        return ApiResponse::unauthorized("Akun tidak ditemukan");
    }

    // CEK PASSWORD — semua tabel pakai kolom 'password'
    if (!\Hash::check($password, $account->password)) {
        return ApiResponse::unauthorized("Password salah");
    }

    // Hapus token lama
    $account->tokens()->delete();

    // Buat token baru
    $token = $account->createToken($role . '_token')->plainTextToken;

    return ApiResponse::success([
        'token' => $token,
        'role' => $role,
        'user' => $account
    ], "Login berhasil sebagai $role");
}


public function registerUser(Request $request)
    {
        $request->validate([
            'email_user' => 'required|email|unique:user,email_user',
            'nama_user' => 'required',
            'no_telp' => 'required',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'email_user' => $request->email_user,
            'nama_user' => $request->nama_user,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message'   => 'Register berhasil',
            'user'      => $user
        ], 201);
    }

}
