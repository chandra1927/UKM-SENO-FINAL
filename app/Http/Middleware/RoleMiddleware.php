<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        
        // Pastikan user sudah login
        if (!$request->user()) {
            // Jika user belum login, arahkan ke halaman login
            return redirect()->route('login'); // atau bisa menggunakan redirect()->guest('/login')
        }

        // Cek apakah role user ada di dalam daftar yang diizinkan
        if (!in_array($request->user()->role, $roles)) {
            // Jika tidak sesuai dengan role yang diizinkan, tampilkan pesan error
            abort(403, 'Akses ditolak.');
        }
        

        // Jika role sesuai, lanjutkan ke permintaan selanjutnya
        return $next($request);
    }
}
