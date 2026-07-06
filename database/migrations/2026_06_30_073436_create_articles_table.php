<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->string('excerpt')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
            $table->string('opd_unit')->nullable();
            $table->json('tags')->nullable();
            $table->string('visibility')->default('public');
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('estimated_read_time')->nullable();
            $table->string('language')->default('id');
            $table->string('version')->nullable();
            $table->string('doc_code')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->integer('progress')->default(0);
            $table->json('attachments')->nullable();
            $table->json('relations')->nullable();
            $table->integer('views')->default(0);
            $table->integer('downloads')->default(0);
            $table->decimal('rating', 3, 2)->default(0); // ✅ WAJIB ADA
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->integer('rating_count')->default(0);
            $table->integer('likes')->default(0);
            $table->integer('bookmarks')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->timestamps();
            
            $table->index(['user_id', 'status', 'category']);
        });
    }
    public function down(): void { Schema::dropIfExists('articles'); }
};