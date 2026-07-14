<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // 🔹 Seeder untuk Role & Permission (Wajib dijalankan terlebih dahulu)
            RolePermissionSeeder::class,

            // 🔹 Seeder data dummy lainnya
            AdminUserSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            SubcategorySeeder::class,
            OpdSeeder::class,
            ArticleSeeder::class,
            BadgeSeeder::class,
        ]);
    }
}