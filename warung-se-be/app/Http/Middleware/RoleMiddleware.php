<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Responses\ApiResponse;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $requiredRole)
    {
        $authUser = $request->user(); // user dari sanctum token

        if (!$authUser) {
            return ApiResponse::forbidden("Token tidak valid atau belum login");
        }

        // Deteksi role dari nama model
        $currentRole = strtolower(class_basename($authUser));

        /*
            Jika model = User        → role: user
            Jika model = Admin       → role: admin
            Jika model = SuperAdmin  → role: superadmin
        */

        if ($currentRole !== strtolower($requiredRole)) {
            return ApiResponse::forbidden("Akses sebagai $requiredRole diperlukan");
        }

        return $next($request);
    }
}
