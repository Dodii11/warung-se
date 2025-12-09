<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Middleware\SubstituteBindings;
use App\Http\Middleware\RoleMiddleware;

class Kernel extends HttpKernel
{
    protected $middleware = [
        SubstituteBindings::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            SubstituteBindings::class,
        ],
        'api' => [
            'throttle:api',
            SubstituteBindings::class,
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
