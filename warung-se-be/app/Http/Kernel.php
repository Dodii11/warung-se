<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Middleware\SubstituteBindings;
use App\Http\Middleware\RoleMiddleware;

class Kernel extends HttpKernel
{
    // Global middleware (dibiarkan kosong atau tambahkan yang kamu perlukan)
    protected $middleware = [
        SubstituteBindings::class, // wajib agar route model binding tetap jalan
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

    protected $routeMiddleware = [
        'role' => RoleMiddleware::class,
    ];
}
