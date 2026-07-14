<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke artikel
            $table->foreignId('article_id')
                  ->constrained('articles')
                  ->onDelete('cascade');

            // Relasi ke user pemberi feedback (nullable jika ada guest)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            // Tipe feedback seperti "Kurang Lengkap", "Sudah Kadaluarsa", dll
            $table->string('feedback_type');

            // Status feedback: Open, In Progress, Resolved, Assigned, Closed
            $table->string('status')->default('Open');

            // Pesan tambahan
            $table->text('message')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};