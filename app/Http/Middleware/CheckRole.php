<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure  $next
     * @param  string  ...$roles  // Role yang diizinkan untuk mengakses halaman ini
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // 2. Ambil nama role dari relasi (jika ada), fallback 'user'
        $userRole = $user->role ? $user->role->name : 'user';

        // 3. Jika role user tidak ada di daftar yang diizinkan, tolak akses
        if (!in_array($userRole, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // 4. Lanjutkan request
        return $next($request);
    }
}