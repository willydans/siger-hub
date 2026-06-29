<?php

// FILE: database/migrations/2026_06_29_000011_create_log_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── SEARCH LOGS ───────────────────────────────────────────
        // Semua keyword yang pernah dicari — untuk analytics & knowledge gap
        Schema::create('search_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('keyword');
            $table->unsignedInteger('result_count')->default(0);
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('searched_at');

            $table->index('keyword');
            $table->index('searched_at');
        });

        // ── FEEDBACKS ─────────────────────────────────────────────
        // User bisa kasih thumbs up/down di artikel
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete(); // staff yang ditugaskan
            $table->enum('type', ['positive', 'negative']); // 👍 atau 👎
            $table->text('note')->nullable();  // komentar singkat (misal: "kurang lengkap")
            $table->enum('status', ['open', 'in_progress', 'resolved'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('search_logs');
    }
};