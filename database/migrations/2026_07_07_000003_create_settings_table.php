<?php

// FILE: database/migrations/2026_07_07_000003_create_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('label')->nullable(); // label untuk tampil di UI admin
            $table->timestamps();
        });

        // Isi default settings
        DB::table('settings')->insert([
            ['key' => 'nama_aplikasi',  'value' => 'AKSARA',                    'label' => 'Nama Aplikasi',  'created_at' => now(), 'updated_at' => now()],
            ['key' => 'nama_instansi',  'value' => 'Diskominfotik Prov. Lampung','label' => 'Nama Instansi', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'deskripsi',      'value' => 'Sistem Manajemen Pengetahuan','label' => 'Deskripsi',    'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};