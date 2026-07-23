<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role; // Menggunakan model Spatie
use Spatie\Permission\Models\Permission; // Menggunakan model Spatie
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    // ========== USER CRUD ==========

    public function index()
    {
        // Menggabungkan pagination milikmu dengan relasi roles Spatie
        $users = User::with('roles')->latest()->paginate(10);
        $roles = Role::with('permissions')->get(); 
        
        return view('admin-users', compact('users', 'roles'));
    }

    public function create()
    {
        return view('admin-users-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'bidang' => 'nullable|string|max:100',
            'role' => 'required|string', // Validasi nama role
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'bidang' => $request->bidang,
            'is_active' => true, // Mempertahankan kolom milikmu
        ]);

        // Assign role default menggunakan spatie
        $user->assignRole($request->role ?? 'user');

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        // Fleksibel: Jika diakses via AJAX (Modal), return JSON. Jika tidak, return View.
        if (request()->ajax()) {
            return response()->json($user->load('roles'));
        }
        
        return view('admin-users-edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'bidang' => 'nullable|string|max:100',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'bidang' => $request->bidang,
        ];

        // Tambahan dari teman: Cek apakah password diisi (opsional)
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Update role menggunakan Spatie
        if ($request->has('role')) {
            $user->syncRoles([$request->role]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Proteksi dari teman: Jangan biarkan admin menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    // ========== EXTRA FEATURES (Dari Teman) ==========

    public function toggleStatus(User $user)
    {
        // Disesuaikan menggunakan is_active boolean milikmu
        $user->update(['is_active' => !$user->is_active]);
        
        return response()->json([
            'success' => true, 
            'is_active' => $user->is_active
        ]);
    }

    public function resetPassword(User $user)
    {
        $newPassword = Str::random(10);
        $user->update(['password' => Hash::make($newPassword)]);
        
        return response()->json(['success' => true, 'new_password' => $newPassword]);
    }

    // ========== ROLE & PERMISSION CRUD (Dari Teman, Disesuaikan ke Spatie) ==========

    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:roles,name']);
        Role::create(['name' => $request->name]);
        return redirect()->route('admin.users.index')->with('success', 'Role berhasil ditambahkan.');
    }

    public function editRole(Role $role)
    {
        return response()->json($role);
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate(['name' => 'required|string|unique:roles,name,' . $role->id]);
        $role->update(['name' => $request->name]);
        return redirect()->route('admin.users.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroyRole(Role $role)
    {
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Role tidak dapat dihapus karena masih digunakan oleh user.');
        }
        $role->delete();
        return redirect()->route('admin.users.index')->with('success', 'Role berhasil dihapus.');
    }

    public function togglePermission(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_name' => 'required|exists:permissions,name'
        ]);

        $role = Role::findById($request->role_id);
        
        // Logika disesuaikan dengan method bawaan Spatie
        if ($role->hasPermissionTo($request->permission_name)) {
            $role->revokePermissionTo($request->permission_name);
            $active = false;
        } else {
            $role->givePermissionTo($request->permission_name);
            $active = true;
        }

        return response()->json([
            'success' => true,
            'active' => $active
        ]);
    }
}