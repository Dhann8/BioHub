<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom category menjadi string agar fleksibel menampung nilai baru
        DB::statement("ALTER TABLE contributions MODIFY COLUMN category ENUM('fauna', 'herbal', 'paper') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE contributions MODIFY COLUMN category ENUM('fauna', 'herbal') NOT NULL");
    }
};
