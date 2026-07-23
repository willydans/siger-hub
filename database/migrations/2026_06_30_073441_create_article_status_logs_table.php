<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('article_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('old_status');
            $table->string('new_status');
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('article_status_logs'); }
};