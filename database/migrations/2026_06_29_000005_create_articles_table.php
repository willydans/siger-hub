<?php

// FILE: database/migrations/2026_06_29_000005_create_articles_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('opd_id')->nullable()->constrained('opds')->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->longText('content');

            // Status workflow: draft → pending → (published | revision | rejected)
            $table->enum('status', [
                'draft',
                'pending',
                'published',
                'revision',
                'rejected',
            ])->default('draft');

            // Siapa yang boleh baca artikel ini
            $table->enum('visibility', [
                'public',      // semua orang termasuk guest
                'restricted',  // hanya user yang login
                'private',     // hanya staff penulis & admin
            ])->default('public');

            $table->integer('version')->default(1);
            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedBigInteger('downloads_count')->default(0);

            // SEO & metadata
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('keywords')->nullable();

            // Referensi & sumber
            $table->text('references')->nullable();

            $table->timestamp('published_at')->nullable();
            $table->softDeletes(); // untuk fitur archive & restore
            $table->timestamps();

            // Full-text search index
            $table->fullText(['title', 'content', 'keywords']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};