<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            // Laravel menggunakan UUID untuk ID notifikasi
            $table->uuid('id')->primary();
            
            // Kolom type akan berisi nama class notification (contoh: App\Notifications\ArticleApprovedNotification)
            $table->string('type');
            
            // Membuat kolom notifiable_type dan notifiable_id secara otomatis (pengganti user_id)
            $table->morphs('notifiable');
            
            // Kolom data ini akan menyimpan JSON berisi article_id, title, message, dll
            $table->text('data');
            
            // Untuk menandai apakah notifikasi sudah dibaca atau belum
            $table->timestamp('read_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};