<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah pengguna sudah login DAN adalah admin
        if (auth()->check() && auth()->user()->isAdmin()) {
            // Jika ya, lanjutkan ke halaman yang dituju
            return $next($request);
        }

        // Jika tidak, tolak akses
        abort(403, 'AKSES DITOLAK, HANYA UNTUK YANG PUNYA PACAR.');
    }
}