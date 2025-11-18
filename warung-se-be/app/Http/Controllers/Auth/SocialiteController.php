<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirect()
{
    return Socialite::driver('google')
        ->redirectUrl('http://127.0.0.1:8000/auth/google/callback')
        ->stateless()
        ->redirect();
}

public function callback()
{
    $googleUser = Socialite::driver('google')
        ->redirectUrl('http://127.0.0.1:8000/auth/google/callback')
        ->stateless()
        ->user();

    $user = User::firstOrCreate(
        ['nama_user' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName(),
            'no_telp' => '08123456789', // atau NULL jika nullable
            'password' => bcrypt(Str::random(16)),
        ]
    );

    $token = $user->createToken('google-login')->plainTextToken;

    return redirect("http://localhost:5173/auth/google/success?token=".$token);
}

}
