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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            
            // Jika feedback berasal dari user yang sudah login
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Jika feedback dari pengunjung umum (guest)
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            
            // Isi feedback
            $table->text('message');
            
            // Rating (opsional, misal 1-5)
            $table->unsignedTinyInteger('rating')->nullable();
            
            // Status feedback: unread (belum dibaca), read (sudah dibaca), resolved (selesai)
            $table->string('status')->default('unread');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};