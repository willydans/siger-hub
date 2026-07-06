<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder {
    public function run(): void {
        $email = 'admin@sigerhub.lampungprov.go.id';
        if (!User::where('email', $email)->exists()) {
            User::create([
                'name' => 'Admin SIGER-Hub',
                'email' => $email,
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'nip' => '000000000000000000',
                'bidang' => 'Administrator',
                'jabatan' => 'Super Admin',
                'no_hp' => '081234567890',
                'bio' => 'Administrator utama sistem.',
                'email_verified_at' => now(),
                'opd' => 'Dinas Kominfo Prov. Lampung'
            ]);
            $this->command->info('✅ Admin dibuat. Email: ' . $email . ' | Pass: password123');
        } else {
            $this->command->info('⚠️ Admin sudah ada.');
        }
    }
}