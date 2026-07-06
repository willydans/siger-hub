<?php
namespace Database\Seeders;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubcategorySeeder extends Seeder {
    public function run(): void {
        $data = [
            'Keamanan Siber' => ['Keamanan Jaringan'],
            'Infrastruktur & Jaringan' => ['Cloud Services'],
            'Pedoman TI' => ['Pengembangan Aplikasi']
        ];
        foreach ($data as $catName => $subs) {
            $cat = Category::where('name', $catName)->first();
            if ($cat) {
                foreach ($subs as $sub) {
                    Subcategory::firstOrCreate(
                        ['category_id' => $cat->id, 'name' => $sub],
                        ['slug' => Str::slug($sub)]
                    );
                }
            }
        }
        $this->command->info('✅ Subkategori berhasil di-seed.');
    }
}