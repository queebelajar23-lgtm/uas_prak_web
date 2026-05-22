<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // 💡 TRICK BYPASS: Jika string parameter kaku, kita bersihkan dan pecah manual
        // Ini mengantisipasi bug parsing dari rute tunggal di web.php
        $flatRoles = [];
        foreach ($roles as $role) {
            if (str_contains($role, ',')) {
                $flatRoles = array_merge($flatRoles, explode(',', $role));
            } else {
                $flatRoles[] = $role;
            }
        }

        // 2. Cek apakah role user ada di dalam daftar flatRoles
        if (in_array($userRole, $flatRoles)) {
            return $next($request);
        }

        // 3. Jika tidak punya role yang sesuai, lempar ke halaman 403
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}