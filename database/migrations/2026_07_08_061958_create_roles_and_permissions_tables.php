<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat tabel roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label')->nullable();
            $table->timestamps();
        });

        // 2. Buat tabel permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label')->nullable();
            $table->timestamps();
        });

        // 3. Buat tabel pivot role_permission
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
            $table->timestamps();
        });

        // 4. Modifikasi tabel users
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom role string yang lama
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            // Tambahkan role_id foreign key
            $table->foreignId('role_id')->nullable()->after('email_verified_at')->constrained('roles')->onDelete('set null');
        });
    }

    public function down(): void
    {
        // Kembalikan struktur tabel users ke semula
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
            $table->string('role')->default('user')->after('email');
        });

        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};