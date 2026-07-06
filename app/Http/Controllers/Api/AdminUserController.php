<?php

// FILE: app/Http/Controllers/Api/AdminUserController.php
// User management khusus admin:
// List, Detail, Create, Update Role/OPD, Disable/Enable, Reset Password, Delete

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Opd;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    use ApiResponse;

    // ── GET /api/v1/admin/users ────────────────────────────────────
    // List semua user dengan filter role, OPD, status, search
    public function index(Request $request): JsonResponse
    {
        $query = User::with('opd')->withCount('articles');

        // Filter role
        if ($request->filled('role')) {
            $query->role($request->role); // scope dari Spatie HasRoles
        }

        // Filter OPD
        if ($request->filled('opd_id')) {
            $query->where('opd_id', $request->opd_id);
        }

        // Filter status aktif/nonaktif
        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
        }

        // Search nama atau email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate($request->get('per_page', 15));

        return $this->success([
            'items'        => UserResource::collection($users->items()),
            'current_page' => $users->currentPage(),
            'last_page'    => $users->lastPage(),
            'total'        => $users->total(),

            // Summary counts untuk dashboard
            'summary' => [
                'total'    => User::count(),
                'admin'    => User::role('admin')->count(),
                'staff'    => User::role('staff')->count(),
                'user'     => User::role('user')->count(),
                'inactive' => User::where('is_active', false)->count(),
            ],
        ]);
    }

    // ── GET /api/v1/admin/users/{id} ──────────────────────────────
    // Detail user lengkap dengan statistik kontribusi
    public function show(int $id): JsonResponse
    {
        $user = User::with('opd')
            ->withCount('articles')
            ->find($id);

        if (!$user) {
            return $this->notFound('User tidak ditemukan.');
        }

        // Statistik artikel per status
        $articleStats = $user->articles()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return $this->success([
            'user'          => new UserResource($user),
            'article_stats' => [
                'total'     => $user->articles_count,
                'published' => $articleStats['published'] ?? 0,
                'draft'     => $articleStats['draft'] ?? 0,
                'pending'   => $articleStats['pending'] ?? 0,
                'revision'  => $articleStats['revision'] ?? 0,
                'rejected'  => $articleStats['rejected'] ?? 0,
            ],
            'last_login_at' => $user->last_login_at?->toDateTimeString(),
        ]);
    }

    // ── POST /api/v1/admin/users ───────────────────────────────────
    // Buat user baru (pengganti register untuk staff/admin)
    // Email langsung terverifikasi — tidak perlu klik link verifikasi
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'opd_id'            => $request->opd_id,
            'phone'             => $request->phone,
            'nip'               => $request->nip,
            'is_active'         => true,
            'email_verified_at' => now(), // langsung verified karena dibuat admin
        ]);

        $user->assignRole($request->role);

        activity()
            ->causedBy($request->user())
            ->performedOn($user)
            ->withProperties(['role' => $request->role])
            ->log('admin_create_user');

        return $this->created(
            new UserResource($user->load('opd')),
            'User berhasil dibuat.'
        );
    }

    // ── PUT /api/v1/admin/users/{id} ──────────────────────────────
    // Update data user (nama, email, OPD, NIP, phone)
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->notFound('User tidak ditemukan.');
        }

        // Cegah admin mengedit dirinya sendiri lewat endpoint ini
        // (gunakan /auth/profile untuk update profil sendiri)
        if ($user->id === $request->user()->id) {
            return $this->error('Gunakan endpoint /auth/profile untuk mengubah profil Anda sendiri.', 422);
        }

        $data = $request->only(['name', 'email', 'opd_id', 'phone', 'nip']);
        $user->update($data);

        // Update role kalau ada perubahan
        if ($request->filled('role')) {
            $user->syncRoles([$request->role]);
        }

        activity()
            ->causedBy($request->user())
            ->performedOn($user)
            ->log('admin_update_user');

        return $this->success(
            new UserResource($user->fresh('opd')),
            'Data user berhasil diperbarui.'
        );
    }

    // ── PUT /api/v1/admin/users/{id}/toggle-active ─────────────────
    // Disable atau Enable akun user (toggle)
    public function toggleActive(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->notFound('User tidak ditemukan.');
        }

        // Admin tidak bisa menonaktifkan dirinya sendiri
        if ($user->id === $request->user()->id) {
            return $this->error('Anda tidak bisa menonaktifkan akun Anda sendiri.', 422);
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        activity()
            ->causedBy($request->user())
            ->performedOn($user)
            ->withProperties(['is_active' => $user->is_active])
            ->log('admin_toggle_user_active');

        return $this->success([
            'is_active' => $user->is_active,
        ], "Akun user berhasil {$status}.");
    }

    // ── POST /api/v1/admin/users/{id}/reset-password ───────────────
    // Reset password user — admin set password baru
    public function resetPassword(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'new_password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::find($id);

        if (!$user) {
            return $this->notFound('User tidak ditemukan.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Hapus semua token aktif user — paksa login ulang
        $user->tokens()->delete();

        activity()
            ->causedBy($request->user())
            ->performedOn($user)
            ->log('admin_reset_password');

        return $this->success(null, 'Password user berhasil direset. Semua sesi aktif telah dihapus.');
    }

    // ── DELETE /api/v1/admin/users/{id} ───────────────────────────
    // Hapus user permanen (hati-hati — artikel tetap ada, user_id jadi null)
    public function destroy(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->notFound('User tidak ditemukan.');
        }

        if ($user->id === $request->user()->id) {
            return $this->error('Anda tidak bisa menghapus akun Anda sendiri.', 422);
        }

        // Cek apakah user punya artikel published — sarankan disable dulu
        $publishedCount = $user->articles()->where('status', 'published')->count();
        if ($publishedCount > 0) {
            return $this->error(
                "User memiliki {$publishedCount} artikel published. Nonaktifkan akun terlebih dahulu daripada menghapus.",
                422
            );
        }

        $userName = $user->name;
        $user->tokens()->delete();
        $user->delete();

        activity()
            ->causedBy($request->user())
            ->withProperties(['deleted_user' => $userName])
            ->log('admin_delete_user');

        return $this->success(null, "User {$userName} berhasil dihapus.");
    }

    // ── GET /api/v1/admin/opds ────────────────────────────────────
    // List OPD untuk dropdown saat buat/edit user
    public function listOpds(): JsonResponse
    {
        $opds = Opd::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return $this->success($opds);
    }
}