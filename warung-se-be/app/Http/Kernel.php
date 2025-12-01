<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Routing\Middleware\SubstituteBindings;
use App\Http\Middleware\RoleMiddleware;

class Kernel extends HttpKernel
{
    protected $middleware = [
        HandleCors::class,
        SubstituteBindings::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            SubstituteBindings::class,
        ],
        'api' => [
            HandleCors::class,
            'throttle:api',
            SubstituteBindings::class,
        ],
    ];

    protected $routeMiddleware = [
        'role' => RoleMiddleware::class,
    ];
}
