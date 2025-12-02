<?php

use Laravel\Sanctum\Sanctum;

return [

    // domain frontend / Postman / client yang stateful
    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', '127.0.0.1, localhost')),

    // guard default untuk token
    'guard' => ['api', 'user', 'admin', 'superadmin'],

    'expiration' => env('SANCTUM_EXPIRATION', 60 * 24),

    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),

    'middleware' => [
        'authenticate_session' => Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
        'encrypt_cookies' => Illuminate\Cookie\Middleware\EncryptCookies::class,
        'validate_csrf_token' => Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
    ],
];
