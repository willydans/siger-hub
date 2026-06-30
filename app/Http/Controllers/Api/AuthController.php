<?php

// FILE: app/Http/Controllers/Api/AuthController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    use ApiResponse;

    // ── POST /api/v1/auth/login ────────────────────────────────────
    public function login(LoginRequest $request): JsonResponse
    {
        // Cek kredensial
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Email atau password salah.', 401);
        }

        $user = Auth::user();

        // Cek apakah akun aktif
        if (!$user->is_active) {
            Auth::logout();
            return $this->error('Akun Anda telah dinonaktifkan. Hubungi administrator.', 403);
        }

        // Update last_login_at
        $user->update(['last_login_at' => now()]);

        // Hapus semua token lama (opsional — satu akun satu sesi aktif)
        // $user->tokens()->delete();

        // Buat token baru dengan nama device/browser
        $tokenName  = $request->header('User-Agent', 'web-client');
        $token      = $user->createToken($tokenName)->plainTextToken;

        // Load relasi OPD supaya muncul di UserResource
        $user->load('opd');

        // Catat activity login
        activity()
            ->causedBy($user)
            ->withProperties(['ip' => $request->ip()])
            ->log('login');

        return $this->success([
            'token' => $token,
            'user'  => new UserResource($user),
        ], 'Login berhasil.');
    }

    // ── POST /api/v1/auth/logout ───────────────────────────────────
    public function logout(Request $request): JsonResponse
    {
        // Hapus hanya token yang sedang dipakai
        $request->user()->currentAccessToken()->delete();

        activity()
            ->causedBy($request->user())
            ->log('logout');

        return $this->success(null, 'Logout berhasil.');
    }

    // ── GET /api/v1/auth/me ────────────────────────────────────────
    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load('opd');

        return $this->success(new UserResource($user));
    }

    // ── PUT /api/v1/auth/profile ───────────────────────────────────
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->only(['name', 'email', 'phone']);

        // Handle upload avatar
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama kalau ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan avatar baru ke storage/app/public/avatars/
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);
        $user->load('opd');

        return $this->success(new UserResource($user), 'Profil berhasil diperbarui.');
    }

    // ── PUT /api/v1/auth/password ──────────────────────────────────
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = $request->user();

        // Verifikasi password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return $this->error('Password saat ini tidak sesuai.', 422);
        }

        // Update password baru
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Opsional: logout semua sesi lain setelah ganti password
        // $user->tokens()->where('id', '!=', $request->user()->currentAccessToken()->id)->delete();

        activity()
            ->causedBy($user)
            ->log('change_password');

        return $this->success(null, 'Password berhasil diubah.');
    }

    // ── POST /api/v1/auth/logout-all ──────────────────────────────
    // Logout dari semua device sekaligus
    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return $this->success(null, 'Logout dari semua perangkat berhasil.');
    }
}