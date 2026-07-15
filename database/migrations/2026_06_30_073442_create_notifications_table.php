<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // Menggunakan auto-increment integer, bukan UUID agar lebih sederhana untuk custom model
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Penerima notifikasi
            $table->foreignId('article_id')->nullable()->constrained('articles')->onDelete('cascade'); // Artikel terkait (jika ada)
            $table->string('type'); // Approval, Revision, Comment, Like, Feedback, System
            $table->string('title'); // Judul Notifikasi
            $table->text('message'); // Isi Pesan Notifikasi
            $table->string('url')->nullable(); // Link tujuan (misal ke /admin/pending-approval)
            $table->boolean('is_read')->default(false); // Status baca
            $table->timestamps(); // created_at & updated_at

            // Tambahkan index agar query filter (type, is_read, user_id) menjadi cepat
            $table->index('user_id');
            $table->index('type');
            $table->index('is_read');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};