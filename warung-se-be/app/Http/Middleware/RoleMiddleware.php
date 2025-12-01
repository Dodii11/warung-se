<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\SuperAdmin;
use App\Responses\ApiResponse;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $authUser = $request->user();

        if (!$authUser) {
            return ApiResponse::forbidden("Token tidak valid atau kamu belum login");
        }

        if (
            ($role === 'user' && !$authUser instanceof User) ||
            ($role === 'admin' && !$authUser instanceof Admin) ||
            ($role === 'superadmin' && !$authUser instanceof SuperAdmin)
        ) {
            return ApiResponse::forbidden("Akses sebagai $role diperlukan");
        }

        return $next($request);
    }
}
