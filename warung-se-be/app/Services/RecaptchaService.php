<!-- TAMBAH FILE RECAPTCHASERVICE DI SERVICES -->
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    /**
     * Verify reCAPTCHA token with Google API
     * 
     * @param string $token
     * @return bool
     */
    public function verify(string $token): bool
    {
        $secretKey = config('services.recaptcha.secret_key');
        
        if (empty($secretKey)) {
            Log::warning('reCAPTCHA secret key is not configured');
            return false;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $token,
            ]);

            if (!$response->successful()) {
                Log::error('reCAPTCHA verification request failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return false;
            }

            $result = $response->json();
            
            if (!isset($result['success'])) {
                Log::error('Invalid reCAPTCHA response format', ['response' => $result]);
                return false;
            }

            if (!$result['success']) {
                Log::warning('reCAPTCHA verification failed', [
                    'error_codes' => $result['error-codes'] ?? []
                ]);
                return false;
            }

            // reCAPTCHA v2 doesn't return a score, so we just check success
            return true;
            
        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
}