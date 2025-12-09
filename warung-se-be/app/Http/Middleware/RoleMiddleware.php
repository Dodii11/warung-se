<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$role)
    {
        $user = $request->user();

        // Pastikan user login
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Pecah parameter yang mengandung koma
        $allowedRoles = [];
        foreach ($role as $r) {
            $allowedRoles = array_merge($allowedRoles, explode(',', $r));
        }

        // Eager load relasi role untuk menghindari lazy loading issue
        $user = $user->load('role');

        // Pastikan relasi role ada dan role_name sesuai
        if (!$user->role || !in_array($user->role->role_name, $allowedRoles)) {
            return response()->json(['message' => 'Forbidden: Role not allowed'], 403);
        }

        return $next($request);
    }
}
