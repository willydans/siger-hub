<?php

// FILE: database/seeders/DatabaseSeeder.php
// Ganti isi file DatabaseSeeder.php yang sudah ada dengan ini

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,   // 1. Roles & permissions dulu
            OpdAndUserSeeder::class,           // 2. OPD & users
            CategoryAndArticleSeeder::class,  // 3. Kategori, tag, & artikel dummy
        ]);

        $this->command->info('');
        $this->command->info('🎉 AKSARA Database seeded successfully!');
    }
}