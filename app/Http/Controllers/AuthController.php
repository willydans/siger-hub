<?php

// FILE: app/Http/Controllers/AuthController.php
// Web auth controller (session-based) — kompatibel dengan Spatie Permission
// Temanmu tidak perlu ubah apapun karena $user->role sudah dijembatani accessor

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) return redirect('/');
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $user = Auth::user();

            // Cek akun aktif
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.']);
            }

            // Jika email belum diverifikasi → kirim OTP
            if (!$user->email_verified_at) {
                $this->sendOtp($user);
                return redirect()->route('otp.verify')->with('email', $user->email);
            }

            $request->session()->regenerate();
            $user->update(['last_login_at' => now()]);

            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors(['email' => 'Email atau password yang Anda masukkan salah.']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nip'      => 'nullable|string|max:50|unique:users,nip',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'nip'       => $request->nip,
            'is_active' => true,
            'joined_at' => now(),
        ]);

        // Assign role via Spatie (bukan simpan ke kolom)
        $user->assignRole('user');

        Auth::login($user);
        $this->sendOtp($user);

        return redirect()->route('otp.verify')->with('email', $user->email);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Anda berhasil logout.');
    }

    // Public — dipanggil dari OtpController juga
    public function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') return redirect()->to('/admin/dashboard');
        if ($user->role === 'staff') return redirect()->to('/staff/dashboard');
        return redirect()->to('/');
    }

    private function sendOtp($user)
    {
        if (!$user) return;

        $otpCode = rand(100000, 999999);
        Otp::create([
            'user_id'    => $user->id,
            'otp_code'   => $otpCode,
            'expires_at' => now()->addMinutes(10),
            'is_used'    => false,
        ]);

        try {
            Mail::to($user->email)->send(new OtpMail($otpCode, $user));
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim OTP ke ' . $user->email . ': ' . $e->getMessage());
        }
    }
}