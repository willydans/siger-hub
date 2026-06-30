<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('article_id')->nullable()->constrained()->onDelete('cascade');
            
            // type: view, download, like, rating
            $table->string('type'); 
            
            // Untuk rating: nilai 1-5. Untuk lainnya null
            $table->integer('value')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_logs');
    }
};