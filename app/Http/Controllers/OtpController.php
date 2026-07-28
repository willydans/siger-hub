<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use App\Models\UserActivity; // ✅ Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OtpMail;
use Carbon\Carbon;

class OtpController extends Controller
{
    /**
     * Ambil user yang sedang menunggu verifikasi OTP dari session.
     * User belum ter-autentikasi sampai OTP benar.
     */
    private function pendingUser(Request $request): ?User
    {
        $userId = $request->session()->get('otp_user_id');
        return $userId ? User::find($userId) : null;
    }

    /**
     * Tampilkan halaman verifikasi OTP
     */
    public function showVerifyForm(Request $request)
    {
        // Jika sudah login penuh & terverifikasi, langsung redirect
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

    /**
     * Verifikasi kode OTP
     */
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

        // ✅ Login user setelah OTP benar
        Auth::login($user, $remember);
        $request->session()->regenerate();

        // ✅ Catat aktivitas login (RIWAYAT LOGIN)
        try {
            UserActivity::create([
                'user_id'    => $user->id,
                'type'       => 'Login',
                'description'=> $user->name . ' login via OTP',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Exception $e) {
            // Jangan sampai proses gagal hanya karena gagal catat aktivitas
            Log::warning('Gagal mencatat aktivitas login via OTP: ' . $e->getMessage());
        }

        return app(AuthController::class)->redirectBasedOnRole($user);
    }

    /**
     * Kirim ulang OTP
     */
    public function resend(Request $request)
    {
        $user = $this->pendingUser($request) ?? (Auth::check() ? Auth::user() : null);

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['otp' => 'Sesi verifikasi tidak ditemukan. Silakan login/daftar kembali.']);
        }

        // Hapus OTP lama yang belum digunakan
        Otp::where('user_id', $user->id)->where('is_used', false)->delete();

        $otpCode = rand(100000, 999999);
        Otp::create([
            'user_id'    => $user->id,
            'otp_code'   => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(10),
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