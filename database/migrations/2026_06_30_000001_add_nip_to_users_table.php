<?php

// FILE: database/migrations/2026_06_30_000001_add_nip_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // NIP opsional — diisi user saat register supaya admin mudah identifikasi
            // untuk pertimbangan upgrade role ke staff
            $table->string('nip', 30)->nullable()->unique()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nip');
        });
    }
};