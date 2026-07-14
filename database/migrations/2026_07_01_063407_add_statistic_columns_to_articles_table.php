<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Dari temanmu
            if (!Schema::hasColumn('articles', 'views')) {
                $table->unsignedBigInteger('views')->default(0);
            }
            
            // Tambahan wajib untuk HomeController kamu agar tidak error
            if (!Schema::hasColumn('articles', 'downloads')) {
                $table->unsignedBigInteger('downloads')->default(0);
            }

            // Dari temanmu
            if (!Schema::hasColumn('articles', 'rating')) {
                $table->decimal('rating', 3, 1)->default(0);
            }
            if (!Schema::hasColumn('articles', 'comments_count')) {
                $table->unsignedBigInteger('comments_count')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Menggunakan array dan hasColumn agar aman saat di-rollback
            $columns = ['views', 'downloads', 'rating', 'comments_count'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('articles', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};