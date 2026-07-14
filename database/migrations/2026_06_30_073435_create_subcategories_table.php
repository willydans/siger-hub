<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Cek apakah tabel sudah ada agar tidak bentrok dengan migration sebelumnya
        if (!Schema::hasTable('subcategories')) {
            Schema::create('subcategories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
                $table->string('name');
                $table->string('slug')->nullable();
                $table->timestamps();
            });
        }
    }
    
    public function down(): void { 
        Schema::dropIfExists('subcategories'); 
    }
};