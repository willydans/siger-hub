<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('feedback')) {
            Schema::create('feedback', function (Blueprint $table) {
                $table->id();
                
                // Relasi ke tabel users (user yang submit feedback)
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                
                // Relasi ke tabel articles
                $table->foreignId('article_id')->nullable()->constrained('articles')->cascadeOnDelete();
                
                // Relasi ke tabel users (Admin/Penulis yang ditugaskan menyelesaikan feedback)
                $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
                
                // Kolom sesuai model
                $table->string('type')->nullable(); // Jenis feedback, misal: "Informasi Tidak Sesuai"
                $table->text('note')->nullable();   // Detail pesan dari user
                $table->string('status')->default('open'); // open, assigned, in progress, resolved
                
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};