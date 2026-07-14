<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission; // ✅ Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->orderBy('name')->get();
        $roles = Role::with('permissions')->get();
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
            'status' => 'active',
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

    // --- Role CRUD ---

    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:roles,name']);
        Role::create(['name' => $request->name, 'label' => $request->label ?? $request->name]);
        return redirect()->route('admin.users')->with('success', 'Role berhasil ditambahkan.');
    }

    public function editRole(Role $role)
    {
        return response()->json($role);
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate(['name' => 'required|string|unique:roles,name,' . $role->id]);
        $role->update(['name' => $request->name, 'label' => $request->label ?? $request->name]);
        return redirect()->route('admin.users')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroyRole(Role $role)
    {
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Role tidak dapat dihapus karena masih digunakan.');
        }
        $role->delete();
        return redirect()->route('admin.users')->with('success', 'Role berhasil dihapus.');
    }

    // ✅ Fitur Baru: Toggle Permission via AJAX
    public function togglePermission(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_name' => 'required|exists:permissions,name'
        ]);

        $role = Role::findOrFail($request->role_id);
        $permission = Permission::where('name', $request->permission_name)->firstOrFail();

        if ($role->permissions()->where('permission_id', $permission->id)->exists()) {
            $role->permissions()->detach($permission->id);
            $active = false;
        } else {
            $role->permissions()->attach($permission->id);
            $active = true;
        }

        return response()->json([
            'success' => true,
            'active' => $active
        ]);
    }
}