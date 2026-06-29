<?php

// FILE: database/seeders/RoleAndPermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache dulu
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ── PERMISSIONS ───────────────────────────────────────────
        $permissions = [
            // Article: read
            'read-public-article',
            'read-restricted-article',
            'read-private-article',

            // Article: interact
            'bookmark-article',
            'comment-article',
            'rate-article',
            'download-attachment',
            'share-article',

            // Article: write (staff)
            'create-article',
            'edit-own-article',
            'delete-own-article',
            'submit-article',
            'upload-attachment',

            // Article: manage (admin)
            'approve-article',
            'reject-article',
            'request-revision',
            'archive-article',
            'delete-any-article',
            'restore-article',
            'rollback-version',

            // User management (admin)
            'manage-users',
            'manage-roles',
            'disable-user',
            'reset-password',

            // Category & Tag
            'manage-categories',
            'manage-tags',

            // Analytics & logs
            'view-analytics',
            'view-search-logs',
            'view-activity-logs',
            'manage-feedbacks',

            // System
            'manage-storage',
            'manage-settings',
            'manage-backup',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ── ROLES & ASSIGN PERMISSIONS ────────────────────────────

        // GUEST — tidak punya role di DB, ini hanya placeholder
        // Guest hanya bisa akses public routes tanpa auth

        // USER — pegawai yang hanya konsumsi knowledge
        $roleUser = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $roleUser->syncPermissions([
            'read-public-article',
            'read-restricted-article',
            'bookmark-article',
            'comment-article',
            'rate-article',
            'download-attachment',
            'share-article',
        ]);

        // STAFF — knowledge creator
        $roleStaff = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $roleStaff->syncPermissions([
            'read-public-article',
            'read-restricted-article',
            'read-private-article',
            'bookmark-article',
            'comment-article',
            'rate-article',
            'download-attachment',
            'share-article',
            'create-article',
            'edit-own-article',
            'delete-own-article',
            'submit-article',
            'upload-attachment',
        ]);

        // ADMIN — knowledge manager
        $roleAdmin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $roleAdmin->syncPermissions(Permission::all());

        $this->command->info('✅ Roles & Permissions seeded!');
    }
}