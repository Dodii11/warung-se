<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
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
            return redirect()->away(
                config('app.frontend_url') . '/login?error=oauth_failed'
            );
        }

        // Cari / buat user
        $user = $this->findOrCreateUser($socialUser);

        // Generate Sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;

        // 🔥 REDIRECT KE ROUTE CALLBACK VUE YANG BENAR
        return redirect()->away(
            config('app.frontend_url') . '/auth/google/callback?token=' . $token
        );
    }

    private function findOrCreateUser($socialUser)
    {
        // Cari user berdasarkan email_user
        $user = Account::where('email_user', $socialUser->getEmail())->first();

        // Kalau belum ada → buat baru
        if (!$user) {
            $user = Account::create([
                'nama_user'  => $socialUser->getName(),
                'email_user' => $socialUser->getEmail(),
                'password'   => bcrypt(str()->random(16)),
                'id_role'    => 1,  // random password
            ]);
        }

        return $user;
    }
}
