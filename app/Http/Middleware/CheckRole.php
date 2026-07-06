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

        // 2. Fallback: Jika role user null, set default ke 'user'
        if (is_null($user->role)) {
            $user->role = 'user';
            $user->save();
        }

        // 3. Cek apakah role user ada di dalam daftar roles yang diizinkan
        if (!in_array($user->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // 4. Lanjutkan request
        return $next($request);
    }
}