<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
                // ✅ PERBAIKAN: pakai role_id + relasi Role, KONSISTEN dengan
                // AuthController::register(). Sebelumnya kode ini mengisi
                // kolom 'role' string yang kemungkinan besar tidak ada di
                // skema tabel users kamu (yang dipakai adalah role_id +
                // tabel roles) — insert semacam itu gagal di level
                // database, dan exception-nya tertelan jadi pesan generik
                // "Gagal login dengan Google".
                $userRole = Role::where('name', 'user')->first();

                $user = User::create([
                    'name'              => $googleUser->getName(),
                    'email'             => $googleUser->getEmail(),
                    'google_id'         => $googleUser->getId(),
                    'password'          => Hash::make(uniqid()),
                    'email_verified_at' => now(), // ✅ Google sudah memverifikasi email ini
                    'role_id'           => $userRole ? $userRole->id : null,
                ]);
            } else {
                $updates = [];

                if (is_null($user->google_id)) {
                    $updates['google_id'] = $googleUser->getId();
                }

                // ✅ TAMBAHAN: kalau user ini sebelumnya daftar manual dan
                // belum sempat verifikasi OTP (mis. kasus littleenterprise07
                // yang masih pending), login via Google tetap membuktikan
                // dia pemilik email itu — jadi langsung tandai terverifikasi
                // juga, supaya tidak nyangkut selamanya menunggu OTP.
                if (is_null($user->email_verified_at)) {
                    $updates['email_verified_at'] = now();
                }

                if (!empty($updates)) {
                    $user->update($updates);
                }
            }

            // Login user dan regenerasi session
            Auth::login($user);
            session()->regenerate();

            // ✅ PERBAIKAN: delegasikan ke AuthController::redirectBasedOnRole()
            // yang sudah benar (pakai $user->role->name), bukan versi lokal
            // di sini yang membandingkan objek relasi dengan string dan
            // tidak akan pernah cocok.
            return app(AuthController::class)->redirectBasedOnRole($user);

        } catch (Exception $e) {
            // Log error untuk debugging — cek storage/logs/laravel.log
            // untuk pesan aslinya kalau error ini muncul lagi.
            Log::error('Google Login Error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors(['google' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }
    }
}