<?php

// FILE: database/migrations/2026_07_07_000001_add_integration_fields_to_users_table.php
// Tambahkan kolom yang dibutuhkan frontend untuk kompatibilitas

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek masing-masing kolom sebelum menambahkan untuk menghindari Duplicate Column Error
            
            if (!Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->nullable()->unique()->after('nip');
            }

            if (!Schema::hasColumn('users', 'bidang')) {
                $table->string('bidang')->nullable()->after('google_id');
            }

            if (!Schema::hasColumn('users', 'jabatan')) {
                $table->string('jabatan')->nullable()->after('bidang');
            }

            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('jabatan');
            }

            if (!Schema::hasColumn('users', 'joined_at')) {
                $table->timestamp('joined_at')->nullable()->after('bio');
            }

            if (!Schema::hasColumn('users', 'preferences')) {
                $table->json('preferences')->nullable()->after('joined_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Gunakan array untuk mengecek dan menghapus (rollback) agar tidak error jika kolom tidak ada
            $columns = ['google_id', 'bidang', 'jabatan', 'bio', 'joined_at', 'preferences'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};