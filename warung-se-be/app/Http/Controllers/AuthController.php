<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // =====================================
    // REGISTER USER
    // =====================================
    public function registerUser(Request $request)
    {
        $request->validate([
            'email_user' => 'required|email|unique:user',
            'nama_user' => 'required|string|max:255',
            'no_telp' => 'required|numeric',
            'password' => 'required|string|min:6',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return response()->json(['message'=>'User registered','user'=>$user],201);
    }

    // =====================================
    // LOGIN USER
    // =====================================
    public function loginUser(Request $request)
    {
        $credentials = $request->only('email_user','password');

        if(Auth::guard('user')->attempt($credentials)){
            return response()->json(['message'=>'User login success']);
        }

        return response()->json(['message'=>'Invalid credentials'],401);
    }

    // =====================================
    // REGISTER ADMIN
    // =====================================
    public function registerAdmin(Request $request)
    {
        $request->validate([
            'email_admin' => 'required|email|unique:admin',
            'nama_admin' => 'required|string|max:255',
            'no_telp' => 'required|numeric',
            'password' => 'required|string|min:6',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $admin = Admin::create($data);

        return response()->json(['message'=>'Admin registered','admin'=>$admin],201);
    }

    // =====================================
    // LOGIN ADMIN
    // =====================================
    public function loginAdmin(Request $request)
    {
        $credentials = $request->only('email_admin','password');

        if(Auth::guard('admin')->attempt($credentials)){
            return response()->json(['message'=>'Admin login success']);
        }

        return response()->json(['message'=>'Invalid credentials'],401);
    }

    // =====================================
    // REGISTER SUPERADMIN
    // =====================================
    public function registerSuperAdmin(Request $request)
    {
        $request->validate([
            'email_super' => 'required|email|unique:super_admin',
            'nama_super' => 'required|string|max:255',
            'no_telp' => 'required|numeric',
            'password' => 'required|string|min:6',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $superadmin = SuperAdmin::create($data);

        return response()->json(['message'=>'Super Admin registered','superadmin'=>$superadmin],201);
    }

    // =====================================
    // LOGIN SUPERADMIN
    // =====================================
    public function loginSuperAdmin(Request $request)
    {
        $credentials = $request->only('email_super','password');

        if(Auth::guard('superadmin')->attempt($credentials)){
            return response()->json(['message'=>'Super Admin login success']);
        }

        return response()->json(['message'=>'Invalid credentials'],401);
    }

    // =====================================
    // LOGOUT
    // =====================================
    public function logout(Request $request, $role)
    {
        switch($role){
            case 'user':
                Auth::guard('user')->logout();
                break;
            case 'admin':
                Auth::guard('admin')->logout();
                break;
            case 'superadmin':
                Auth::guard('superadmin')->logout();
                break;
        }

        return response()->json(['message'=>'Logged out']);
    }
}
