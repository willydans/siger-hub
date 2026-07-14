<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pengecekan agar tidak error jika tabel sudah ada
        if (!Schema::hasTable('bookmarks')) {
            Schema::create('bookmarks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('article_id')->constrained()->cascadeOnDelete();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Pastikan baris ini ada agar tabel benar-benar terhapus saat di-rollback/refresh
        Schema::dropIfExists('bookmarks');
    }
};