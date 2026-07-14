<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class OtpController extends Controller
{
    /**
     * Menampilkan form verifikasi OTP
     */
    public function showVerifyForm(Request $request)
    {
        if (auth()->user()->email_verified_at) {
            return app(AuthController::class)->redirectBasedOnRole(auth()->user());
        }
        return view('verify-otp')->with('email', $request->email ?? auth()->user()->email);
    }

    /**
     * Memverifikasi kode OTP yang dikirim user
     */
    public function verify(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);
        $user = auth()->user();
        
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

        return app(AuthController::class)->redirectBasedOnRole($user);
    }

    /**
     * Mengirim ulang kode OTP
     */
    public function resend(Request $request)
    {
        $user = auth()->user();
        
        $otpCode = rand(100000, 999999);
        Otp::create([
            'user_id'    => $user->id,
            'otp_code'   => $otpCode,
            'expires_at' => now()->addMinutes(10),
            'is_used'    => false
        ]);

        // ✅ PERBAIKAN: Tangkap error pengiriman email agar user tahu jika ada masalah
        try {
            Mail::to($user->email)->send(new OtpMail($otpCode, $user));
            return redirect()->back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            // Catat error ke log Laravel agar developer bisa cek
            \Log::error('Gagal mengirim ulang OTP ke ' . $user->email . ': ' . $e->getMessage());
            
            // Tampilkan pesan error ke pengguna
            return redirect()->back()->withErrors(['otp' => 'Gagal mengirim email. Pastikan konfigurasi SMTP di .env sudah benar (Gunakan App Password Google).']);
        }
    }
}