<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //FUNGSI LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|max:50',
        ]);
        if(Auth::attempt($request->only('email', 'password'), $request->remember)) {
            
            //Kode ini buat ngalihin user (pelanggan) ke dashboard user (redirect /user/pesanan dan /dashboard disesuaikan)
            if(Auth::user()->role == 'user') return redirect('/user/pesanan');
            return redirect('/dashboard');
        }
        return back() -> with('failed', 'Email atau Password salah');
    }

    //FUNGSI REGISTER
    function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'password' => 'required|max:50',
            'confirm_password' => 'required|max:50|same:password',
        ]);
        return redirect('/login');

        /* $user=User::create($request->all());
        Auth::login($user);
        return redirect('/user/pesanan'); */
    }
}
