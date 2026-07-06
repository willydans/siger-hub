<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    public function run(): void {
        $email = 'staff@lampungprov.go.id';
        if (!User::where('email', $email)->exists()) {
            User::create([
                'name' => 'Budi ASN Staff',
                'email' => $email,
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'nip' => '198807102022011001',
                'opd' => 'Dinas Kominfotik',
                'jabatan' => 'Pengelola Konten Teknis',
                'bidang' => 'E-Government & Knowledge Base',
                'email_verified_at' => now(),
                'preferences' => ['theme' => 'dark', 'language' => 'id']
            ]);
            $this->command->info('✅ Staff dibuat. Email: ' . $email . ' | Pass: password123');
        } else {
            $this->command->info('⚠️ Staff sudah ada.');
        }
    }
}