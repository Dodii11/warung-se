<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Middleware\SubstituteBindings;
use App\Http\Middleware\RoleMiddleware;

class Kernel extends HttpKernel
{
    protected $middleware = [
        SubstituteBindings::class,

        //TAMBAHAN
        \Illuminate\Http\Middleware\HandleCors::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            SubstituteBindings::class,
        ],
        'api' => [

            //TAMBAHAN ENSURE DAN SUBTITUTE
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    // <CHANGE> Tambahkan ke $middlewareAliases untuk compatibility dengan Laravel 11+
    protected $middlewareAliases = [
        'role' => RoleMiddleware::class,
    ];

    // Atau jika menggunakan Laravel 10 ke bawah, gunakan ini:
    protected $routeMiddleware = [
        'role' => RoleMiddleware::class,
    ];
}
