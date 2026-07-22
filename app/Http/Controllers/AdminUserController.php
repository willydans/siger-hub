<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function index()
    {
        // ✅ Hanya tampilkan role Admin, Staff, dan User (selain itu dihapus)
        $users = User::with('role')->orderBy('name')->get();
        $roles = Role::whereIn('name', ['admin', 'staff', 'user'])->get();
        return view('admin-users', compact('users', 'roles'));
    }

    // --- User CRUD ---

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'bidang' => 'nullable|string|max:100',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'bidang' => $request->bidang,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return response()->json($user->load('role'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'bidang' => 'nullable|string|max:100',
            'role_id' => 'required|exists:roles,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'bidang' => $request->bidang,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function toggleStatus(User $user)
    {
        $user->update(['status' => $user->status === 'active' ? 'inactive' : 'active']);
        return response()->json(['success' => true, 'status' => $user->status]);
    }

    public function resetPassword(User $user)
    {
        $newPassword = Str::random(10);
        $user->update(['password' => Hash::make($newPassword)]);
        return response()->json(['success' => true, 'new_password' => $newPassword]);
    }
    
    // ✅ Semua method CRUD Role & Permission (storeRole, editRole, updateRole, destroyRole, togglePermission) telah dihapus.
}