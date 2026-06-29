<?php

// FILE: database/migrations/2026_06_29_000007_create_attachments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->foreignId('uploaded_by')->constrained('users');

            $table->string('original_name');        // nama file asli dari user
            $table->string('file_name');             // nama file di storage (uuid-based)
            $table->string('file_path');             // path lengkap di storage
            $table->string('disk')->default('local'); // local | nextcloud
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size'); // dalam bytes

            // Tipe file untuk filter & icon di frontend
            $table->enum('file_type', [
                'image', 'pdf', 'word', 'excel', 'powerpoint', 'video', 'zip', 'other'
            ])->default('other');

            $table->unsignedBigInteger('download_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};