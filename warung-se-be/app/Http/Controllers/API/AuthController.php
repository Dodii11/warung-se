<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * REGISTER MANUAL → AUTO LOGIN
     */
    public function register(Request $request)
    {
        $request->validate([
            'email_user' => 'required|email|unique:account,email_user',
            'nama_user'  => 'required|string',
            'password'   => 'required|string|min:6',
        ]);

        $roleUser = Role::where('role_name', 'user')->first();
        if (!$roleUser) {
            return response()->json(['message' => 'Default role user tidak ditemukan'], 500);
        }

        $user = Account::create([
            'email_user' => $request->email_user,
            'nama_user'  => $request->nama_user,
            'password'   => Hash::make($request->password),
            'id_role'    => $roleUser->id_role,
            'status'     => 'aktif',
           
        ]);

        // 🔥 AUTO LOGIN (Sanctum)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Register & login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id_user'    => $user->id_user,
                'nama_user'  => $user->nama_user,
                'email_user' => $user->email_user,
                'role'       => $user->role->role_name
            ]
        ]);
    }

    /**
     * LOGIN MANUAL
     */
    public function login(Request $request)
    {
        $request->validate([
            'email_user' => 'required|email',
            'password'   => 'required|string'
        ]);

        $user = Account::with('role')
            ->where('email_user', $request->email_user)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Akun tidak ditemukan'], 404);
        }

        // ❌ Akun Google tidak boleh login manual
        if ($user->login_type === 'google') {
            return response()->json([
                'message' => 'Akun ini harus login menggunakan Google'
            ], 403);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Password salah'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id_user'    => $user->id_user,
                'nama_user'  => $user->nama_user,
                'email_user' => $user->email_user,
                'role'       => $user->role->role_name
            ]
        ]);
    }

    /**
     * LOGIN GOOGLE → AUTO REGISTER + AUTO LOGIN
     */
    public function googleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $roleUser = Role::where('role_name', 'user')->first();
        if (!$roleUser) {
            return response()->json(['message' => 'Default role user tidak ditemukan'], 500);
        }

        $user = Account::with('role')
            ->where('email_user', $googleUser->getEmail())
            ->first();

        if (!$user) {
            // 🔥 AUTO REGISTER
            $user = Account::create([
                'nama_user'  => $googleUser->getName(),
                'email_user' => $googleUser->getEmail(),
                'password'   => bcrypt(str()->random(16)), // dummy password
                'google_id'  => $googleUser->getId(),
                'id_role'    => $roleUser->id_role,
                'status'     => 'aktif',
                
            ]);
        }

        // 🔥 AUTO LOGIN
        $token = $user->createToken('auth_token')->plainTextToken;

        return redirect()->to(
            'http://localhost:5173/auth/google-success?token=' . $token
        );
    }

    /**
     * LOGOUT
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
