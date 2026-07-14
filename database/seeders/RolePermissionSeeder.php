<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Permissions
        $permissions = [
            'create', 'read', 'update', 'delete',
            'approve', 'export', 'backup', 'restore', 'analytics'
        ];

        foreach ($permissions as $perm) {
            Permission::create(['name' => $perm, 'label' => ucfirst($perm)]);
        }

        // Roles
        $superAdmin = Role::create(['name' => 'super_admin', 'label' => 'Super Admin']);
        $admin = Role::create(['name' => 'admin', 'label' => 'Admin']);
        $reviewer = Role::create(['name' => 'reviewer', 'label' => 'Reviewer']);
        $staff = Role::create(['name' => 'staff', 'label' => 'Staff']);
        $user = Role::create(['name' => 'user', 'label' => 'User']);

        // Assign permissions
        $superAdmin->permissions()->sync(Permission::all());
        $admin->permissions()->sync(Permission::whereIn('name', ['create', 'read', 'update', 'delete', 'approve', 'export', 'analytics'])->get());
        $reviewer->permissions()->sync(Permission::whereIn('name', ['read', 'approve'])->get());
        $staff->permissions()->sync(Permission::whereIn('name', ['create', 'read', 'update', 'export'])->get());
    }
}