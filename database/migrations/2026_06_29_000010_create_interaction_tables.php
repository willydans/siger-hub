<?php

// FILE: database/migrations/2026_06_29_000010_create_interaction_tables.php
// Satu migration untuk semua tabel interaksi user supaya lebih rapi

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── BOOKMARKS ─────────────────────────────────────────────
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'article_id']); // 1 user hanya bisa bookmark 1x per artikel
        });

        // ── COMMENTS ──────────────────────────────────────────────
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            // parent_id untuk nested comment (balasan komentar)
            $table->foreignId('parent_id')->nullable()->constrained('comments')->nullOnDelete();
            $table->text('body');
            $table->boolean('is_approved')->default(true); // bisa diatur jika butuh moderasi
            $table->softDeletes();
            $table->timestamps();
        });

        // ── RATINGS ───────────────────────────────────────────────
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->unsignedTinyInteger('value'); // 1-5
            $table->timestamps();

            $table->unique(['user_id', 'article_id']); // 1 user hanya bisa rating 1x per artikel
        });

        // ── ARTICLE VIEWS (History) ────────────────────────────────
        Schema::create('article_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('ip_address', 45)->nullable(); // untuk guest tracking
            $table->string('user_agent')->nullable();
            $table->timestamp('viewed_at');

            $table->index(['user_id', 'article_id']);
            $table->index('viewed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_views');
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('bookmarks');
    }
};