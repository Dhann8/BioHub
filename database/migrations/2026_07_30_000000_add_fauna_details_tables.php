<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add fields to taxonomies
        Schema::table('taxonomies', function (Blueprint $table) {
            $table->string('kingdom')->nullable()->default('Animalia');
            $table->string('phylum')->nullable()->default('Chordata');
            $table->string('order')->nullable();
            $table->string('family')->nullable();
        });

        // 2. Add detailed fields to faunas
        Schema::table('faunas', function (Blueprint $table) {
            $table->string('map_image_url')->nullable();
            $table->text('taxonomy_description')->nullable();
            $table->string('lifespan')->nullable(); // e.g. "~20 Tahun"
            $table->string('offspring_count')->nullable(); // e.g. "1"
            $table->string('gestation_period')->nullable(); // e.g. "300 Hari"
            $table->string('social_pattern')->nullable(); // e.g. "Soliter"
            $table->string('iucn_code')->nullable(); // e.g. "EN", "CR"
            $table->text('iucn_description')->nullable();
            $table->text('legal_status')->nullable();
            $table->text('population_trend')->nullable();
        });

        // 3. Create fauna_physical_characteristics
        Schema::create('fauna_physical_characteristics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fauna_id')->constrained('faunas')->onDelete('cascade');
            $table->string('size_and_weight')->nullable();
            $table->text('distinctive_features')->nullable();
            $table->timestamps();
        });

        // 4. Create fauna_ecological_infos
        Schema::create('fauna_ecological_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fauna_id')->constrained('faunas')->onDelete('cascade');
            $table->text('habitat_description')->nullable();
            $table->text('diet_and_behavior')->nullable();
            $table->text('quote')->nullable();
            $table->timestamps();
        });

        // 5. Create fauna_galleries
        Schema::create('fauna_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fauna_id')->constrained('faunas')->onDelete('cascade');
            $table->string('image_url');
            $table->string('caption')->nullable();
            $table->timestamps();
        });

        // 6. Create fauna_conservation_programs
        Schema::create('fauna_conservation_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fauna_id')->constrained('faunas')->onDelete('cascade');
            $table->text('title_or_description');
            $table->timestamps();
        });

        // 7. Create fauna_threats
        Schema::create('fauna_threats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fauna_id')->constrained('faunas')->onDelete('cascade');
            $table->string('icon')->nullable()->default('fa-solid fa-triangle-exclamation');
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fauna_threats');
        Schema::dropIfExists('fauna_conservation_programs');
        Schema::dropIfExists('fauna_galleries');
        Schema::dropIfExists('fauna_ecological_infos');
        Schema::dropIfExists('fauna_physical_characteristics');

        Schema::table('faunas', function (Blueprint $table) {
            $table->dropColumn([
                'map_image_url',
                'taxonomy_description',
                'lifespan',
                'offspring_count',
                'gestation_period',
                'social_pattern',
                'iucn_code',
                'iucn_description',
                'legal_status',
                'population_trend'
            ]);
        });

        Schema::table('taxonomies', function (Blueprint $table) {
            $table->dropColumn(['kingdom', 'phylum', 'order', 'family']);
        });
    }
};
