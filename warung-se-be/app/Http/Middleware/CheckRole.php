<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Pastikan user terautentikasi
        if (! $request->user()) {
            return redirect('/login');
        }

        // Cek peran
        if ($role === 'super_admin' && ! $request->user()->isSuperAdmin()) {
            return abort(403, 'Akses ditolak: Anda bukan Super Admin.');
        }

        if ($role === 'admin' && ! $request->user()->isAdmin()) {
            // Catatan: is_admin() sudah mencakup super_admin dari Model User
            return abort(403, 'Akses ditolak: Anda bukan Admin.');
        }

        return $next($request);
    }
}
