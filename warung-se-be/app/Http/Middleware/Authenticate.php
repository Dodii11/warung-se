<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    /**
     * Handle untuk API request
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // Jika ini adalah API request, jangan redirect
        if ($request->expectsJson()) {
            if ($this->authenticate($request, $guards) === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated',
                    'timestamp' => now()->toIso8601String()
                ], 401);
            }
        }

        return $next($request);
    }

    /**
     * Authenticate guards
     */
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if (\Illuminate\Support\Facades\Auth::guard($guard)->check()) {
                return true;
            }
        }

        return false;
    }
}
