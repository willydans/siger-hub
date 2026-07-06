<?php
namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder {
    public function run(): void {
        $names = ['SOP (Standar Operasional)', 'Pedoman TI', 'Keamanan Siber', 'Infrastruktur & Jaringan'];
        foreach ($names as $n) {
            Category::firstOrCreate(['name' => $n], ['slug' => Str::slug($n)]);
        }
        $this->command->info('✅ Kategori berhasil di-seed.');
    }
}