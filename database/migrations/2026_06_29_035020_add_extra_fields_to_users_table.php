<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('email');
            $table->string('opd')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('bidang')->nullable();
            $table->date('joined_at')->nullable();
            $table->json('preferences')->nullable(); // Simpan Mode Gelap, Bahasa, Font, Notif Email/Web
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nip', 'opd', 'jabatan', 'bidang', 'joined_at', 'preferences']);
        });
    }
};