<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pastikan user sudah login
        if (!$request->user()) {
            return response()->json(['message' => 'Silahkan Login Terbih dahulu'], 401);
        }

        // Cek apakah role user termasuk dalam daftar yang diperbolehkan
        if (!in_array($request->user()->role, $roles)) {
            return response()->json(['message' => 'Kamu Tidak Punya Akses Ke halaman ini'], 403);
        }

        return $next($request);
    }
}
