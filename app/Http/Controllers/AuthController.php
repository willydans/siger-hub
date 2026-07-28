<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Otp;
use App\Models\Role;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OtpMail;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login / register
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
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
        ]);

        $credentials = $request->only('email', 'password');

        // Validasi kredensial (tanpa login dulu)
        if (!Auth::validate($credentials)) {
            return back()->withErrors(['email' => 'Email atau password salah.']);
        }

        $user = User::where('email', $credentials['email'])->first();

        // Jika email belum diverifikasi, kirim OTP dan arahkan ke halaman verifikasi
        if (!$user->email_verified_at) {
            $request->session()->put('otp_user_id', $user->id);
            $request->session()->put('otp_remember', $request->boolean('remember'));

            $otpSent = $this->sendOtp($user);
            if (!$otpSent) {
                return back()->with('warning', 'Gagal mengirim kode OTP. Periksa konfigurasi email Anda.');
            }

            return redirect()->route('otp.verify')->with('email', $user->email);
        }

        // Login sukses (email sudah terverifikasi)
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // ✅ Catat aktivitas login
        $this->recordActivity($user->id, 'Login', 'Login ke sistem', $request);

        return $this->redirectBasedOnRole($user);
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

        $userRole = Role::where('name', 'user')->first();
        $roleId = $userRole ? $userRole->id : null;

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'nip'      => $request->nip,
            'role_id'  => $roleId
        ]);

        // ✅ Catat aktivitas registrasi
        $this->recordActivity($user->id, 'Register', 'Mendaftarkan akun baru', $request);

        // Simpan ID user di session untuk proses OTP (belum login)
        $request->session()->put('otp_user_id', $user->id);
        $request->session()->put('otp_remember', false);

        // Kirim OTP
        $otpSent = $this->sendOtp($user);

        if (!$otpSent) {
            return redirect()->route('otp.verify')
                ->with('email', $user->email)
                ->with('warning', 'Gagal mengirim kode OTP. Periksa konfigurasi email Anda.');
        }

        return redirect()->route('otp.verify')->with('email', $user->email);
    }

    /**
     * Proses logout (wajib POST)
     */
    public function logout(Request $request)
    {
        // ✅ Catat aktivitas logout sebelum user benar-benar logout
        if (Auth::check()) {
            $this->recordActivity(Auth::id(), 'Logout', 'Keluar dari sistem', $request);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil logout.');
    }

    /**
     * Redirect user berdasarkan role setelah login/verifikasi
     */
    public function redirectBasedOnRole($user)
{
    $roleName = $user->role;

    return match ($roleName) {
        'admin' => redirect()->to('/admin/dashboard'),
        'staff' => redirect()->to('/staff/dashboard'),
        default => redirect()->route('home.public'),
    };
}

    /**
     * Kirim Email OTP
     */
    private function sendOtp($user): bool
    {
        if (!$user) return false;

        $otpCode = rand(100000, 999999);

        Otp::updateOrCreate(
            ['user_id' => $user->id],
            [
                'otp_code'   => $otpCode,
                'expires_at' => Carbon::now()->addMinutes(10),
                'is_used'    => false
            ]
        );

        try {
            Mail::to($user->email)->send(new OtpMail($otpCode, $user));
            return true;
        } catch (\Exception $e) {
            Log::error('Gagal kirim OTP ke ' . $user->email . ': ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Helper untuk mencatat aktivitas user ke tabel user_activities
     */
    private function recordActivity(int $userId, string $type, string $description, Request $request): void
    {
        try {
            UserActivity::create([
                'user_id'    => $userId,
                'type'       => $type,
                'description'=> $description,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => Carbon::now(),
            ]);
        } catch (\Exception $e) {
            // Jangan sampai proses gagal hanya karena gagal mencatat aktivitas
            Log::warning('Gagal mencatat aktivitas: ' . $e->getMessage());
        }
    }
}