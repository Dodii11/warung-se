<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        switch($role){
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

        return redirect('/login'); // atau bisa json jika API
    }
}
