<?php

// FILE: database/seeders/OpdAndUserSeeder.php

namespace Database\Seeders;

use App\Models\Opd;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OpdAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // ── OPD DATA ──────────────────────────────────────────────
        $opds = [
            ['name' => 'Diskominfotik Provinsi Lampung',         'slug' => 'diskominfotik'],
            ['name' => 'Biro Hukum Setda Provinsi Lampung',      'slug' => 'biro-hukum'],
            ['name' => 'Dinas Pendidikan Provinsi Lampung',      'slug' => 'dinas-pendidikan'],
            ['name' => 'Dinas Kesehatan Provinsi Lampung',       'slug' => 'dinas-kesehatan'],
            ['name' => 'Dinas PUPR Provinsi Lampung',            'slug' => 'dinas-pupr'],
            ['name' => 'Dinas Perhubungan Provinsi Lampung',     'slug' => 'dinas-perhubungan'],
            ['name' => 'BPKAD Provinsi Lampung',                 'slug' => 'bpkad'],
            ['name' => 'Bappeda Provinsi Lampung',               'slug' => 'bappeda'],
        ];

        foreach ($opds as $opd) {
            Opd::firstOrCreate(['slug' => $opd['slug']], [
                'name'        => $opd['name'],
                'slug'        => $opd['slug'],
                'description' => null,
                'is_active'   => true,
            ]);
        }

        $diskominfotik = Opd::where('slug', 'diskominfotik')->first();

        // ── USERS ─────────────────────────────────────────────────

        // Admin
        $admin = User::firstOrCreate(['email' => 'admin@aksara.lampung.go.id'], [
            'name'     => 'Administrator AKSARA',
            'email'    => 'admin@aksara.lampung.go.id',
            'password' => Hash::make('Admin@12345'),
            'opd_id'   => $diskominfotik->id,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Staff 1
        $staff1 = User::firstOrCreate(['email' => 'staff1@aksara.lampung.go.id'], [
            'name'     => 'Budi Santoso',
            'email'    => 'staff1@aksara.lampung.go.id',
            'password' => Hash::make('Staff@12345'),
            'opd_id'   => $diskominfotik->id,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $staff1->assignRole('staff');

        // Staff 2
        $staff2 = User::firstOrCreate(['email' => 'staff2@aksara.lampung.go.id'], [
            'name'     => 'Siti Rahayu',
            'email'    => 'staff2@aksara.lampung.go.id',
            'password' => Hash::make('Staff@12345'),
            'opd_id'   => $diskominfotik->id,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $staff2->assignRole('staff');

        // User biasa
        $user1 = User::firstOrCreate(['email' => 'user1@aksara.lampung.go.id'], [
            'name'     => 'Agus Pratama',
            'email'    => 'user1@aksara.lampung.go.id',
            'password' => Hash::make('User@12345'),
            'opd_id'   => $diskominfotik->id,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $user1->assignRole('user');

        $this->command->info('✅ OPD & Users seeded!');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin', 'admin@aksara.lampung.go.id', 'Admin@12345'],
                ['Staff', 'staff1@aksara.lampung.go.id', 'Staff@12345'],
                ['Staff', 'staff2@aksara.lampung.go.id', 'Staff@12345'],
                ['User', 'user1@aksara.lampung.go.id', 'User@12345'],
            ]
        );
    }
}