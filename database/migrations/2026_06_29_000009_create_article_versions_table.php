<?php

// FILE: database/migrations/2026_06_29_000009_create_article_versions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users');

            $table->unsignedInteger('version_number');

            // Snapshot lengkap artikel saat versi ini disimpan (JSON)
            // Menyimpan: title, content, thumbnail, category_id, tags, dll
            $table->json('snapshot');

            $table->string('change_summary')->nullable(); // ringkasan perubahan
            $table->timestamps();

            $table->unique(['article_id', 'version_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_versions');
    }
};