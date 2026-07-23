<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');
            $table->integer('estimated_read_time')->nullable();
            $table->string('language', 5)->default('id');
            $table->string('doc_code')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->unsignedTinyInteger('progress')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['subcategory_id', 'estimated_read_time', 'language', 'doc_code', 'valid_from', 'valid_until', 'progress']);
        });
    }
};