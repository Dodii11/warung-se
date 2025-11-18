<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'no_telp'   => 'required',
            'password'  => 'required'
        ]);

        $credentials = [
            'no_telp' => $request->no_telp,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Sanctum Token
            $token = $user->createToken('login-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'token' => $token,
                'user' => $user
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Nomor telepon atau password salah'
        ], 401);
    }


    // REGISTER (kalau butuh)
    public function register(Request $request)
    {
        $request->validate([
            'nama_user' => 'required',
            'no_telp' => 'required|unique:users,no_telp',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'nama_user' => $request->nama_user,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'user' => $user
        ]);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}
