<?php

// FILE: database/migrations/2026_06_29_000002_add_fields_to_users_table.php
// Migration ini MENAMBAHKAN kolom ke tabel users yang sudah ada
// Jangan hapus migration users bawaan Laravel

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('opd_id')->nullable()->constrained('opds')->nullOnDelete()->after('id');
            $table->string('avatar')->nullable()->after('email');
            $table->string('phone')->nullable()->after('avatar');
            $table->boolean('is_active')->default(true)->after('phone');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['opd_id']);
            $table->dropColumn(['opd_id', 'avatar', 'phone', 'is_active', 'last_login_at']);
        });
    }
};