<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Responses\ApiResponse;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        switch($role) {
            case 'user':
                if(Auth::guard('user')->check()) return $next($request);
                break;
            case 'admin':
                if(Auth::guard('admin')->check()) return $next($request);
                break;
            case 'superadmin':
                if(Auth::guard('superadmin')->check()) return $next($request);
                break;
        }

        // Return JSON error untuk API requests
        if ($request->expectsJson()) {
            return ApiResponse::forbidden("Akses sebagai $role diperlukan");
        }

        return redirect('/login');
    }
}
