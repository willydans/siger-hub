<?php
namespace Database\Seeders;
use App\Models\Opd;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OpdSeeder extends Seeder {
    public function run(): void {
        $names = ['Dinas Kominfo', 'Diskominfo', 'Bappeda'];
        foreach ($names as $n) {
            Opd::firstOrCreate(['name' => $n], ['slug' => Str::slug($n)]);
        }
        $this->command->info('✅ OPD berhasil di-seed.');
    }
}