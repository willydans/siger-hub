<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialiteController extends Controller
{
    /**
     * Redirect pengguna ke halaman login Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Handle callback dari Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cari user berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Jika user belum ada, buat akun baru dengan email_verified_at = now()
                $user = User::create([
                    'name'              => $googleUser->getName(),
                    'email'             => $googleUser->getEmail(),
                    'google_id'         => $googleUser->getId(),
                    'password'          => Hash::make(uniqid()),
                    'email_verified_at' => now(), // ✅ Google sudah terverifikasi
                    'role'              => 'user',
                ]);
            } else {
                // Jika user sudah ada, pastikan google_id tersimpan
                if (is_null($user->google_id)) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
            }

            // Login user dan regenerasi session
            Auth::login($user);
            session()->regenerate();

            // Redirect berdasarkan role (sama seperti AuthController)
            return $this->redirectBasedOnRole($user);

        } catch (Exception $e) {
            // Log error untuk debugging
            \Log::error('Google Login Error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors(['google' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }
    }

    /**
     * Redirect berdasarkan role (konsisten dengan AuthController)
     */
    private function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->to('/admin/dashboard');
        }
        if ($user->role === 'staff') {
            return redirect()->to('/staff/dashboard');
        }
        return redirect()->to('/');
    }
}