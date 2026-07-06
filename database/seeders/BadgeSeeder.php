<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            ['name' => 'Top Contributor', 'icon' => '🏆', 'description' => 'Kontribusi terbanyak'],
            ['name' => 'Knowledge Master', 'icon' => '📚', 'description' => 'Master Pengetahuan'],
            ['name' => 'Most Viewed', 'icon' => '👁', 'description' => 'Tayangan Tertinggi'],
            ['name' => '100 Articles', 'icon' => '📄', 'description' => 'Mencapai 100 Artikel'],
        ];

        foreach ($badges as $b) {
            Badge::firstOrCreate(
                ['name' => $b['name']],
                ['slug' => Str::slug($b['name']), 'icon' => $b['icon'], 'description' => $b['description']]
            );
        }

        $this->command->info('✅ Badge berhasil di-seed.');
    }
}