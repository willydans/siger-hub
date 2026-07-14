<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Log;

class OtpController extends Controller
{
    /**
     * Ambil user yang sedang menunggu verifikasi OTP dari session.
     *
     * ✅ PERBAIKAN: sebelumnya seluruh controller ini bergantung pada
     * auth()->user(), yang HANYA ada karena register()/login() login-kan
     * user sebelum waktunya. Sekarang user belum ter-autentikasi sama
     * sekali sampai OTP benar, jadi kita ambil dari 'otp_user_id' yang
     * disimpan di session oleh AuthController.
     */
    private function pendingUser(Request $request): ?User
    {
        $userId = $request->session()->get('otp_user_id');
        return $userId ? User::find($userId) : null;
    }

    public function showVerifyForm(Request $request)
    {
        // Kalau ada session login penuh & sudah terverifikasi, tidak perlu ke sini
        if (Auth::check() && Auth::user()->email_verified_at) {
            return app(AuthController::class)->redirectBasedOnRole(Auth::user());
        }

        $user = $this->pendingUser($request);

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Sesi verifikasi tidak ditemukan atau sudah kadaluarsa. Silakan login/daftar kembali.']);
        }

        return view('verify-otp')->with('email', $user->email);
    }

    public function verify(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $user = $this->pendingUser($request);

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['otp' => 'Sesi verifikasi tidak ditemukan atau sudah kadaluarsa. Silakan login/daftar kembali.']);
        }

        $otp = Otp::where('user_id', $user->id)
                  ->where('otp_code', $request->otp)
                  ->where('is_used', false)
                  ->where('expires_at', '>', now())
                  ->latest()
                  ->first();

        if (!$otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau telah kadaluarsa.']);
        }

        $otp->update(['is_used' => true]);
        $user->update(['email_verified_at' => now()]);

        $remember = $request->session()->pull('otp_remember', false);
        $request->session()->forget('otp_user_id');

        // ✅ Baru di sini user benar-benar login, SETELAH OTP terbukti benar
        Auth::login($user, $remember);
        $request->session()->regenerate();

        return app(AuthController::class)->redirectBasedOnRole($user);
    }

    public function resend(Request $request)
    {
        // Dukung dua kemungkinan: user masih "pending" (belum login penuh),
        // atau (edge case) sudah login tapi somehow belum verified.
        $user = $this->pendingUser($request) ?? (Auth::check() ? Auth::user() : null);

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['otp' => 'Sesi verifikasi tidak ditemukan. Silakan login/daftar kembali.']);
        }

        $otpCode = rand(100000, 999999);
        Otp::create([
            'user_id'    => $user->id,
            'otp_code'   => $otpCode,
            'expires_at' => now()->addMinutes(10),
            'is_used'    => false
        ]);

        try {
            Mail::to($user->email)->send(new OtpMail($otpCode, $user));
            return redirect()->back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            Log::error('Gagal mengirim ulang OTP ke ' . $user->email . ': ' . $e->getMessage());
            return redirect()->back()->withErrors(['otp' => 'Gagal mengirim email. Pastikan konfigurasi SMTP di .env sudah benar!']);
        }
    }
}