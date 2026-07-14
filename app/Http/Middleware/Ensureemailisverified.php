<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Lapisan pengaman tambahan (defense-in-depth).
 *
 * Kalau entah bagaimana ada session yang authenticated tapi
 * email_verified_at masih null (misalnya dari provider login lain seperti
 * Google, atau bug lain di masa depan), user dipaksa logout dan diarahkan
 * ke halaman verifikasi OTP — TIDAK dibiarkan mengakses halaman
 * dashboard/staff/admin sama sekali.
 *
 * Pasang middleware ini di semua route group yang butuh akses penuh,
 * misalnya prefix('staff') dan prefix('admin'), bersanding dengan 'auth'.
 */
class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !$user->email_verified_at) {
            $userId = $user->id;

            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $request->session()->put('otp_user_id', $userId);

            return redirect()->route('otp.verify')
                ->withErrors(['email' => 'Silakan verifikasi email Anda terlebih dahulu.']);
        }

        return $next($request);
    }
}