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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('article_id')->nullable()->constrained()->onDelete('set null');
            
            // jenis aktivitas: read, download, rate, comment, bookmark, like, search, share
            $table->string('type'); 
            
            $table->json('metadata')->nullable(); // Simpan rating value (misal: 5), durasi baca (5 menit), dll.
            $table->timestamp('created_at')->useCurrent(); // Waktu aktivitas terjadi
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
};