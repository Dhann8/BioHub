<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambahan kolom detail pada tabel herbals (botanical & preparation info)
        Schema::table('herbals', function (Blueprint $table) {
            $table->string('plant_family')->nullable()->after('scientific_name');
            $table->string('origin_region')->nullable()->after('plant_family');
            $table->text('morphology_description')->nullable()->after('description');
            $table->json('plant_parts')->nullable()->after('morphology_description'); // ["Daun","Rimpang","Akar"]
            $table->string('cultivation_zone')->nullable()->after('plant_parts'); // e.g., Dataran rendah, Dataran tinggi
            $table->string('map_image_url')->nullable()->after('image_url');
        });

        // 2. Tabel Kandungan Aktif Herbal
        Schema::create('herbal_active_compounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('herbal_id')->constrained('herbals')->onDelete('cascade');
            $table->string('compound_name');
            $table->text('pharmacological_effect')->nullable();
            $table->timestamps();
        });

        // 3. Tabel Galeri Herbal
        Schema::create('herbal_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('herbal_id')->constrained('herbals')->onDelete('cascade');
            $table->string('image_url');
            $table->string('caption')->nullable();
            $table->timestamps();
        });

        // 4. Tabel Interaksi / Kontraindikasi Herbal
        Schema::create('herbal_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('herbal_id')->constrained('herbals')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('severity')->default('Perhatian'); // Perhatian, Sedang, Tinggi
            $table->timestamps();
        });

        // 5. Tambahkan kolom icon_svg ke tabel symptoms (jika belum ada)
        if (!Schema::hasColumn('symptoms', 'icon_svg')) {
            Schema::table('symptoms', function (Blueprint $table) {
                $table->string('icon_class')->nullable()->after('symptom_name'); // e.g. fa-solid fa-head-side-cough
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('herbal_interactions');
        Schema::dropIfExists('herbal_galleries');
        Schema::dropIfExists('herbal_active_compounds');

        Schema::table('herbals', function (Blueprint $table) {
            $table->dropColumn([
                'plant_family', 'origin_region', 'morphology_description',
                'plant_parts', 'cultivation_zone', 'map_image_url'
            ]);
        });
    }
};
