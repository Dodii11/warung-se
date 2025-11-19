<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
   protected function redirectTo($request)
{
    // Jangan redirect untuk API, cukup return null agar middleware kembalikan 401 JSON
    if (!$request->expectsJson()) {
        return null;
    }
}
}
