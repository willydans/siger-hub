<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Otp;        // Pastikan model Otp sudah dibuat
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login / register
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('login');
    }

    /**
     * Proses login manual (email & password)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.'
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $user = Auth::user();

            // Jika email belum diverifikasi, kirim OTP dan arahkan ke halaman verifikasi
            if (!$user->email_verified_at) {
                $this->sendOtp($user);
                return redirect()->route('otp.verify')->with('email', $user->email);
            }

            // Regenerasi session untuk mencegah session fixation
            $request->session()->regenerate();

            // Redirect berdasarkan role
            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.'
        ]);
    }

    /**
     * Proses registrasi akun baru
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nip'      => 'nullable|string|max:50'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'nip'      => $request->nip,
            'role'     => 'user'
        ]);

        Auth::login($user);
        $this->sendOtp($user);

        return redirect()->route('otp.verify')->with('email', $user->email);
    }

    /**
     * Proses logout (wajib POST)
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil logout.');
    }

    /**
     * ✅ FIX: Diubah dari 'private' menjadi 'public'.
     * Method ini dipanggil dari OtpController lewat app(AuthController::class)->redirectBasedOnRole(...),
     * yaitu dari LUAR class ini. PHP tidak mengizinkan pemanggilan method 'private'
     * dari luar class-nya, sekalipun lewat instance yang di-resolve via app().
     * Karena dipanggil dari luar, method ini wajib 'public'.
     *
     * Redirect berdasarkan role (Relatif, otomatis menyesuaikan domain)
     */
    public function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->to('/admin/dashboard');
        }
        if ($user->role === 'staff') {
            return redirect()->to('/staff/dashboard');
        }
        return redirect()->to('/');
    }

    /**
     * Mengirim Email OTP ke user
     */
    private function sendOtp($user)
    {
        if (!$user) return;

        $otpCode = rand(100000, 999999);
        Otp::create([
            'user_id'    => $user->id,
            'otp_code'   => $otpCode,
            'expires_at' => now()->addMinutes(10),
            'is_used'    => false
        ]);

        try {
            Mail::to($user->email)->send(new OtpMail($otpCode, $user));
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim OTP ke ' . $user->email . ': ' . $e->getMessage());
        }
    }
}