<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            
            // ✨ PERBAIKAN UTAMA: Tambahkan ->nullable() agar Guest (user_id = null) bisa tercatat
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            
            $table->foreignId('article_id')->nullable()->constrained('articles')->onDelete('set null');
            $table->string('type'); // Jenis aktivitas (Upload Artikel, Edit Artikel, View Home, dll)
            $table->text('description')->nullable(); // Keterangan tambahan
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
};