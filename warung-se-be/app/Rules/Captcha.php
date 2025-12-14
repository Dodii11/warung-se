<!--TAMBAH/BIKIN FILE CAPTCHA DI RULES -->
<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Services\RecaptchaService;

class Captcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Tambah kode $fail buat jaga-jaga (opsional)
        if (!$value) {
            ('Captcha is required.');
            return;
        }

        $recaptchaService = new RecaptchaService();
        if (!$recaptchaService -> verify($value)) {
            ('Captcha verification failed.');
        }
    }
}
