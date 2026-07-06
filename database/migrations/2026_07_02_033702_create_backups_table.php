<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Log Backup
        Schema::create('backups', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('file_path')->nullable();
            $table->string('size')->nullable();
            $table->string('status')->default('success'); // success, failed, pending
            $table->timestamps();
        });

        // Tabel Pengaturan Jadwal Backup
        Schema::create('backup_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('frequency')->default('daily'); // daily, weekly, monthly
            $table->time('time')->default('02:00');
            $table->string('storage_driver')->default('local');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backup_schedules');
        Schema::dropIfExists('backups');
    }
};