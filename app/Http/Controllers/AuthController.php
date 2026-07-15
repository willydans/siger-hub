<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Otp;
use App\Models\Role;
use App\Models\UserActivity; // ✨ Tambahkan import ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Log;

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

        if (!Auth::validate($credentials)) {
            return back()->withErrors(['email' => 'Email atau password salah.']);
        }

        $user = User::where('email', $credentials['email'])->first();

        if (!$user->email_verified_at) {
            // Simpan id user sementara di session, JANGAN Auth::login() dulu
            $request->session()->put('otp_user_id', $user->id);
            $request->session()->put('otp_remember', $request->boolean('remember'));

            $this->sendOtp($user);
            return redirect()->route('otp.verify')->with('email', $user->email);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // ✨ CATAT AKTIVITAS LOGIN
        UserActivity::create([
            'user_id'    => $user->id,
            'type'       => 'Login',
            'description'=> $user->name . ' berhasil login ke sistem',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

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

        // ✨ CATAT AKTIVITAS REGISTER (sebelum OTP dikirim)
        UserActivity::create([
            'user_id'    => $user->id,
            'type'       => 'Register',
            'description'=> $user->name . ' mendaftarkan akun baru',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Jangan Auth::login($user) dulu — simpan id-nya saja di session
        $request->session()->put('otp_user_id', $user->id);
        $request->session()->put('otp_remember', false);

        // Kirim OTP, jika gagal kita kasih pesan di session flash
        $otpSent = $this->sendOtp($user);

        $redirect = redirect()->route('otp.verify')->with('email', $user->email);

        if (!$otpSent) {
            return $redirect->with('warning', 'Kami gagal mengirim kode OTP ke email Anda. Pastikan konfigurasi SMTP Anda benar di .env!');
        }

        return $redirect;
    }

    /**
     * Proses logout (wajib POST)
     */
    public function logout(Request $request)
    {
        // ✨ CATAT AKTIVITAS LOGOUT sebelum user benar-benar logout
        if (Auth::check()) {
            UserActivity::create([
                'user_id'    => Auth::id(),
                'type'       => 'Logout',
                'description'=> Auth::user()->name . ' keluar dari sistem',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil logout.');
    }

    /**
     * Mengarahkan user berdasarkan role setelah login/verifikasi
     */
    public function redirectBasedOnRole($user)
    {
        $roleName = $user->role ? $user->role->name : 'user';

        if ($roleName === 'admin') {
            return redirect()->to('/admin/dashboard');
        }
        if ($roleName === 'staff') {
            return redirect()->to('/staff/dashboard');
        }

        // User biasa diarahkan ke Welcome Page
        return redirect()->route('home.public');
    }

    /**
     * Mengirim Email OTP (return boolean agar tahu berhasil/gagal)
     */
    private function sendOtp($user)
    {
        if (!$user) return false;

        $otpCode = rand(100000, 999999);
        Otp::create([
            'user_id'    => $user->id,
            'otp_code'   => $otpCode,
            'expires_at' => now()->addMinutes(10),
            'is_used'    => false
        ]);

        try {
            Mail::to($user->email)->send(new OtpMail($otpCode, $user));
            return true;
        } catch (\Exception $e) {
            Log::error('Gagal mengirim OTP ke ' . $user->email . ': ' . $e->getMessage());
            return false;
        }
    }
}