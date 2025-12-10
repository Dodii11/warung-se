<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)
            ->stateless()
            ->redirect();
    }

    public function handleProvideCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)
                ->stateless()
                ->user();
        } catch (\Exception $e) {
            return redirect("http://localhost:5173/login?error=oauth_failed");
        }

        // Login based on email saja
        $user = $this->findOrCreateUser($socialUser);

        // Generate Sanctum Token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Redirect ke FE dengan token
        return redirect("http://localhost:5173/callback?token=$token");
    }

    private function findOrCreateUser($socialUser)
    {
        // Cari user berdasarkan email_user
        $user = User::where('email_user', $socialUser->getEmail())->first();

        // Kalau belum ada → buat baru
        if (!$user) {
            $user = User::create([
                'nama_user'  => $socialUser->getName(),
                'email_user' => $socialUser->getEmail(),
                'password'   => bcrypt(str()->random(16)), // random password
            ]);
        }

        return $user;
    }
}
