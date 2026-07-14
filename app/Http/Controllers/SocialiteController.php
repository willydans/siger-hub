<?php

// FILE: app/Http/Controllers/SocialiteController.php
// Versi yang kompatibel dengan Spatie Permission (tidak pakai kolom 'role')

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Buat user baru — email langsung terverifikasi karena dari Google
                $user = User::create([
                    'name'              => $googleUser->getName(),
                    'email'             => $googleUser->getEmail(),
                    'google_id'         => $googleUser->getId(),
                    'password'          => Hash::make(uniqid()),
                    'email_verified_at' => now(),
                    'is_active'         => true,
                    'joined_at'         => now(),
                ]);

                // Assign role default via Spatie (bukan kolom 'role')
                $user->assignRole('user');

            } else {
                // User sudah ada, update google_id kalau belum ada
                if (is_null($user->google_id)) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }

                // Cek akun aktif
                if (!$user->is_active) {
                    return redirect()->route('login')
                        ->withErrors(['google' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.']);
                }
            }

            Auth::login($user);
            session()->regenerate();

            // Update last_login_at
            $user->update(['last_login_at' => now()]);

            return $this->redirectBasedOnRole($user);

        } catch (Exception $e) {
            \Log::error('Google Login Error: ' . $e->getMessage());
            return redirect()->route('login')
                ->withErrors(['google' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }
    }

    // Pakai getRoleAttribute accessor dari User model
    private function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') return redirect()->to('/admin/dashboard');
        if ($user->role === 'staff') return redirect()->to('/staff/dashboard');
        return redirect()->to('/');
    }
}