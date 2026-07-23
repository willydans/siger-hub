<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Menambahkan 'archived' ke dalam daftar ENUM yang diizinkan
        DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('draft', 'pending', 'revision', 'published', 'archived') NOT NULL DEFAULT 'draft'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('draft', 'pending', 'revision', 'published') NOT NULL DEFAULT 'draft'");
    }
};