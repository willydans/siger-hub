<?php

// FILE: database/migrations/2026_07_07_000005_create_supporting_tables.php
// Tabel pendukung yang dibutuhkan controller frontend

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── USER ACTIVITIES ───────────────────────────────────────
        // Cek apakah tabel user_activities sudah ada sebelum membuatnya
        if (!Schema::hasTable('user_activities')) {
            Schema::create('user_activities', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('article_id')->nullable()->constrained('articles')->nullOnDelete();
                $table->string('type');           // 'Upload Artikel', 'Edit Cepat', dll
                $table->text('description')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->string('user_agent')->nullable();
                $table->timestamps();

                $table->index(['user_id', 'created_at']);
            });
        }

        // ── SUBCATEGORIES ─────────────────────────────────────────
        // Cek apakah tabel subcategories sudah ada sebelum membuatnya
        if (!Schema::hasTable('subcategories')) {
            Schema::create('subcategories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
                $table->string('name');
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Di sini kodenya sudah aman karena menggunakan dropIfExists bawaan Laravel
        Schema::dropIfExists('subcategories');
        Schema::dropIfExists('user_activities');
    }
};