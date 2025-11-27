<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Responses\ApiResponse;

class AuthController extends Controller
{
    // ===============================
    // REGISTER USER
    // ===============================
    public function registerUser(Request $request)
    {
        $validated = $request->validate([
            'email_user' => 'required|email|unique:users,email_user',
            'nama_user' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'email_user' => $validated['email_user'],
            'nama_user' => $validated['nama_user'],
            'no_telp' => $validated['no_telp'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::created([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'User berhasil terdaftar');
    }

    // ===============================
    // LOGIN USER
    // ===============================
    public function loginUser(Request $request)
    {
        $validated = $request->validate([
            'email_user' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email_user', $validated['email_user'])->first();
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return ApiResponse::unauthorized('Kredensial tidak valid');
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::success([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Login user berhasil');
    }

    // ===============================
    // LOGIN ADMIN
    // ===============================
    public function loginAdmin(Request $request)
    {
        $validated = $request->validate([
            'email_admin' => 'required|email',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('email_admin', $validated['email_admin'])->first();
        if (!$admin || !Hash::check($validated['password'], $admin->password)) {
            return ApiResponse::unauthorized('Kredensial admin tidak valid');
        }

        $token = $admin->createToken('auth_token')->plainTextToken;

        return ApiResponse::success([
            'admin' => $admin,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Login admin berhasil');
    }

    // ===============================
    // LOGIN SUPERADMIN
    // ===============================
    public function loginSuperAdmin(Request $request)
    {
        $validated = $request->validate([
            'email_super' => 'required|email',
            'password' => 'required|string',
        ]);

        $superAdmin = SuperAdmin::where('email_super', $validated['email_super'])->first();
        if (!$superAdmin || !Hash::check($validated['password'], $superAdmin->password)) {
            return ApiResponse::unauthorized('Kredensial super admin tidak valid');
        }

        $token = $superAdmin->createToken('auth_token')->plainTextToken;

        return ApiResponse::success([
            'super_admin' => $superAdmin,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Login super admin berhasil');
    }

    // ===============================
    // ADD ADMIN (oleh SuperAdmin)
    // ===============================
    public function addAdmin(Request $request)
    {
        $validated = $request->validate([
            'email_admin' => 'required|email|unique:admins,email_admin',
            'nama_admin' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        $admin = Admin::create([
            'email_admin' => $validated['email_admin'],
            'nama_admin' => $validated['nama_admin'],
            'no_telp' => $validated['no_telp'],
            'password' => Hash::make($validated['password']),
        ]);

        return ApiResponse::created([
            'admin' => $admin
        ], 'Admin berhasil ditambahkan');
    }

    // ===============================
    // LOGOUT (user/admin/superadmin)
    // ===============================
    public function logout(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return ApiResponse::unauthorized('User tidak ditemukan');
        }

        $user->tokens()->delete();

        return ApiResponse::success(null, 'Logout berhasil');
    }
}
