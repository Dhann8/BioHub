<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            // Memastikan kolom token cukup untuk menyimpan hash 6 digit angka
            $table->string('token')->change();
        });
    }

    public function down(): void
    {
        //
    }
};
