<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email_user' => 'required|email|unique:account,email_user',
            'nama_user' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $roleUser = Role::where('role_name', 'user')->first();
        if(!$roleUser){
            return response()->json(['message' => 'Default role user tidak ditemukan'], 500);
        }

        $user = Account::create([
            'email_user' => $request->email_user,
            'nama_user' => $request->nama_user,
            'password' => Hash::make($request->password),
            'id_role' => $roleUser->id_role,
            'status' => 'aktif'
        ]);

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
}
