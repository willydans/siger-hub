<?php

// FILE: database/seeders/CategoryAndArticleSeeder.php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryAndArticleSeeder extends Seeder
{
    public function run(): void
    {
        // ── CATEGORIES ────────────────────────────────────────────
        $categories = [
            ['name' => 'SOP',              'icon' => 'document-text',  'color' => '#3B82F6'],
            ['name' => 'Regulasi',         'icon' => 'scale',           'color' => '#8B5CF6'],
            ['name' => 'Pedoman Teknis',   'icon' => 'cog',             'color' => '#10B981'],
            ['name' => 'Panduan Layanan',  'icon' => 'question-mark-circle', 'color' => '#F59E0B'],
            ['name' => 'Pengumuman',       'icon' => 'megaphone',       'color' => '#EF4444'],
            ['name' => 'FAQ',              'icon' => 'chat-bubble-left-right', 'color' => '#06B6D4'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => Str::slug($cat['name'])], [
                'name'      => $cat['name'],
                'slug'      => Str::slug($cat['name']),
                'icon'      => $cat['icon'],
                'color'     => $cat['color'],
                'is_active' => true,
            ]);
        }

        // ── TAGS ──────────────────────────────────────────────────
        $tags = ['VPN', 'Firewall', 'SPBE', 'OPD', 'Data', 'Keamanan', 'Jaringan', 'Server', 'Email'];
        foreach ($tags as $tag) {
            Tag::firstOrCreate(['slug' => Str::slug($tag)], [
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]);
        }

        // ── DUMMY ARTICLES ────────────────────────────────────────
        $staff  = User::role('staff')->first();
        $admin  = User::role('admin')->first();
        $sopCat = Category::where('slug', 'sop')->first();

        if ($staff && $sopCat) {
            // Artikel published
            $article = Article::firstOrCreate(['slug' => 'sop-penggunaan-vpn-dinas'], [
                'user_id'      => $staff->id,
                'category_id'  => $sopCat->id,
                'opd_id'       => $staff->opd_id,
                'title'        => 'SOP Penggunaan VPN Dinas',
                'slug'         => 'sop-penggunaan-vpn-dinas',
                'content'      => '<h2>1. Tujuan</h2><p>SOP ini mengatur prosedur penggunaan VPN di lingkungan Diskominfotik Provinsi Lampung.</p><h2>2. Ruang Lingkup</h2><p>Seluruh pegawai yang membutuhkan akses jaringan internal dari luar kantor.</p><h2>3. Prosedur</h2><ol><li>Unduh client VPN yang telah ditentukan</li><li>Masukkan konfigurasi server dari tim IT</li><li>Autentikasi menggunakan akun SSO</li><li>Koneksi berhasil, akses jaringan internal tersedia</li></ol>',
                'status'       => 'published',
                'visibility'   => 'public',
                'version'      => 1,
                'published_at' => now(),
                'keywords'     => 'VPN, jaringan, remote, akses',
            ]);

            $vpnTag = Tag::where('slug', 'vpn')->first();
            if ($vpnTag) {
                $article->tags()->syncWithoutDetaching([$vpnTag->id]);
            }

            // Artikel draft
            Article::firstOrCreate(['slug' => 'draft-sop-pengelolaan-email-dinas'], [
                'user_id'     => $staff->id,
                'category_id' => $sopCat->id,
                'opd_id'      => $staff->opd_id,
                'title'       => 'SOP Pengelolaan Email Dinas',
                'slug'        => 'draft-sop-pengelolaan-email-dinas',
                'content'     => '<p>Masih dalam pengerjaan...</p>',
                'status'      => 'draft',
                'visibility'  => 'private',
                'version'     => 1,
            ]);
        }

        $this->command->info('✅ Categories, Tags & Dummy Articles seeded!');
    }
}