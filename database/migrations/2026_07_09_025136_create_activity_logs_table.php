<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('causer_id')->nullable();
            $table->string('description')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();

            // Indeks untuk performa query
            $table->index(['subject_id', 'subject_type']);
            $table->index('causer_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};