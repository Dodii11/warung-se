<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

//TAMBAH 2 INI
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

// RECAPTCHA
use App\Rules\Captcha;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email_user' => 'required|email|unique:account,email_user',
            'nama_user' => 'required|string',
            'password' => 'required|string|min:6',

            // --- TAMBAH VALIDASI CAPTCHA ---
            'g-recaptcha-response' => ['required', new Captcha()],
        ]);

        $roleUser = Role::where('role_name', 'user')->first();
        if(!$roleUser){
            return response()->json(['message' => 'Default role user tidak ditemukan'], 500);
        }

        $code = rand(100000, 999999);

        $user = Account::create([
            'email_user' => $request->email_user,
            'nama_user' => $request->nama_user,
            'password' => Hash::make($request->password),
            'id_role' => $roleUser->id_role,
            'status' => 'aktif',

            // SIMPAN OTP
            'otp_code' => $code,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // KIRIM EMAIL VERIFIKASI
        Mail::to($user->email_user)->send(new VerifyEmail($code));

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id_user' => $user->id_user,
                'nama_user' => $user->nama_user,
                'email_user' => $user->email_user,
                'role' => $user->role->role_name
            ]
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email_user' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = Account::with('role')->where('email_user', $request->email_user)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id_user' => $user->id_user,
                'nama_user' => $user->nama_user,
                'email_user' => $user->email_user,
                'role' => $user->role->role_name
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    // TAMBAH FUNGSI INI
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email_user' => 'required|email',
            'otp_code' => 'required|string'
        ]);

        $user = Account::where('email_user', $request->email_user)->first();
        if (!$user) {
            return response()->json(['message' => 'Pengguna Tidak Ditemukan'], 404);
        }

        if ($user->otp_code !== $request->otp_code || now()->greaterThan($user->otp_expires_at)) {
            return response()->json(['message' => 'Kode OTP Kadaluarsa atau Salah'], 400);
        }

        // Hapus kode OTP setelah verifikasi berhasil
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->email_verified_at = now(); // Tandai email sebagai terverifikasi
        $user->save();

        return response()->json(['message' => 'Email berhasil diverifikasi']);
    }
}
