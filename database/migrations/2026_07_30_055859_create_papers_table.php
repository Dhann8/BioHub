<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('authors');
            $table->text('abstract');
            $table->string('type'); // Contoh: Clinical Trial, In Vitro
            $table->string('category'); // Contoh: Botany, Pharmacology
            $table->integer('publication_year');
            $table->string('journal_name');
            $table->json('compounds'); // Contoh: ["Curcumin", "Flavonoid"]
            $table->integer('views')->default(0);
            $table->integer('citations')->default(0);
            $table->string('pdf_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('papers');
    }
};