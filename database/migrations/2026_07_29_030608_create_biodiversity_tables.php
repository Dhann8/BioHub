<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Kategori Taksonomi
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->id();
            $table->string('class_name'); // e.g., Mammalia, Aves, Reptilia, Amphibia
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 2. Tabel Utama Fauna (Dilengkapi Atribut Filter Wizard)
        Schema::create('faunas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('taxonomy_id')->constrained('taxonomies')->onDelete('cascade');
            $table->string('local_name');
            $table->string('scientific_name');
            $table->enum('iucn_status', ['CR', 'EN', 'VU', 'NT', 'LC']); // Status Kepunahan
            
            // Atribut Tambahan untuk Identification Wizard / Filter Interaktif
            $table->enum('size', ['Kecil', 'Sedang', 'Besar'])->default('Sedang'); // Ukuran Tubuh
            $table->json('physical_features')->nullable(); // e.g., ["Berekor Panjang", "Nokturnal", "Bermotif Totol"]
            $table->string('primary_habitat')->nullable(); // e.g., Hutan Hujan, Pesisir, Pegunungan

            $table->text('description');
            $table->string('image_url')->nullable();
            $table->softDeletes(); // Soft Delete untuk integritas data
            $table->timestamps();
        });

        // 3. Tabel Lokasi Habitat Fauna (Web GIS)
        Schema::create('fauna_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fauna_id')->constrained('faunas')->onDelete('cascade');
            $table->string('region_name'); // e.g., Taman Nasional Ujung Kulon, Sumatra Barat
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->timestamps();
        });

        // 4. Tabel Utama Herbal (TOGA)
        Schema::create('herbals', function (Blueprint $table) {
            $table->id();
            $table->string('local_name');
            $table->string('scientific_name');
            $table->text('description');
            $table->text('preparation_method');
            $table->text('dosage_guide');
            $table->text('safety_warning')->nullable();
            $table->enum('evidence_level', ['Empirical', 'Clinical_Trial'])->default('Empirical');
            $table->string('image_url')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // 5. Tabel Master Gejala Penyakit
        Schema::create('symptoms', function (Blueprint $table) {
            $table->id();
            $table->string('symptom_name');
            $table->string('icon_svg')->nullable();
            $table->timestamps();
        });

        // 6. Pivot Table: Relasi Many-to-Many (Herbal <-> Symptom)
        Schema::create('herbal_symptom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('herbal_id')->constrained('herbals')->onDelete('cascade');
            $table->foreignId('symptom_id')->constrained('symptoms')->onDelete('cascade');
            $table->string('plant_part_used')->nullable(); // e.g., Daun, Rimpang, Akar
            $table->timestamps();
        });

        // 7. Tabel Crowdsourcing (Usulan Komunitas)
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('category', ['fauna', 'herbal']);
            $table->string('title');
            $table->text('description');
            $table->string('photo_url')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contributions');
        Schema::dropIfExists('herbal_symptom');
        Schema::dropIfExists('symptoms');
        Schema::dropIfExists('herbals');
        Schema::dropIfExists('fauna_locations');
        Schema::dropIfExists('faunas');
        Schema::dropIfExists('taxonomies');
    }
};