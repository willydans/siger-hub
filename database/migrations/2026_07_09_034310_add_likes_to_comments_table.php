<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Tambahkan kolom likes jika belum ada
            if (!Schema::hasColumn('comments', 'likes')) {
                $table->integer('likes')->default(0);
            }

            // Pastikan parent_id dan status sudah ada (jika belum, tambahkan)
            if (!Schema::hasColumn('comments', 'parent_id')) {
                $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade');
            }
            if (!Schema::hasColumn('comments', 'status')) {
                $table->string('status')->default('published');
            }
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['likes', 'parent_id', 'status']);
        });
    }
};