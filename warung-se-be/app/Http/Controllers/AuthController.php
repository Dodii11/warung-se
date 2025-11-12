<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman Login
     */
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    /**
     * Menangani proses Login (verifikasi kredensial)
     */
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            // Sesuaikan dengan kolom login Anda (misalnya 'no_telp', atau 'nama_user')
            'no_telp' => 'required|numeric', 
            'password' => 'required',
        ]);

        // 2. Coba Lakukan Otentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Arahkan User berdasarkan Peran (Role)
            $user = Auth::user();
            
            if ($user->isSuperAdmin()) {
                return redirect()->intended('/superadmin/settings');
            } elseif ($user->isAdmin()) {
                // is_admin() mencakup admin dan super admin
                return redirect()->intended('/admin/dashboard');
            } else {
                // User biasa
                return redirect()->intended('/profile');
            }
        }

        // 4. Gagal Login
        return back()->withErrors([
            'no_telp' => 'Nomor telepon atau password salah.',
        ])->onlyInput('no_telp');
    }

    /**
     * Menangani proses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}