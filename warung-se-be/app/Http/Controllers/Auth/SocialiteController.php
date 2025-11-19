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
        ['email' => $googleUser->getEmail()],
        [
            'nama_user' => $googleUser->getName(),
            'no_telp' => $phone ?? '-', // default aman
            'password' => bcrypt(Str::random(16)),
        ]
    );

    $token = $user->createToken('google-login')->plainTextToken;

    return redirect("http://localhost:5173/auth/google/success?token=".$token);
}

}
