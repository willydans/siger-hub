<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // Menampilkan halaman utama User Management
    public function index()
    {
        $users = User::latest()->paginate(10);
        
        // Cukup panggil nama filenya langsung karena berada di root folder views
        return view('admin-users', compact('users'));
    }

    // Menampilkan form tambah user (buat view ini nanti jika diperlukan)
    public function create()
    {
        return view('admin-users-create');
    }

    // Menyimpan data user baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'bidang' => $request->bidang,
            'is_active' => true,
        ]);

        // Assign role default menggunakan spatie
        $user->assignRole($request->role ?? 'user');

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    // Menampilkan form edit (buat view ini nanti jika diperlukan)
    public function edit(User $user)
    {
        // Ubah dari 'admin.users.edit' menjadi 'admin-users-edit'
        return view('admin-users-edit', compact('user'));
    }

    // Menyimpan perubahan data user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'bidang' => $request->bidang,
        ]);

        if ($request->has('role')) {
            $user->syncRoles([$request->role]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    // Menghapus user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}