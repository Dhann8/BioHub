<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fauna extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'taxonomy_id',
        'local_name',
        'scientific_name',
        'iucn_status',
        'size',
        'physical_features',
        'primary_habitat',
        'description',
        'image_url',
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
    ];

    protected $casts = [
        'physical_features' => 'array',
    ];

    public function getImageUrlAttribute($value)
    {
        if (!$value) {
            return null;
        }

        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        return asset(ltrim($value, '/'));
    }

    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
    }

    public function locations()
    {
        return $this->hasMany(FaunaLocation::class);
    }

    public function physicalCharacteristics()
    {
        return $this->hasOne(FaunaPhysicalCharacteristic::class);
    }

    public function ecologicalInfo()
    {
        return $this->hasOne(FaunaEcologicalInfo::class);
    }

    public function gallery()
    {
        return $this->hasMany(FaunaGallery::class);
    }

    public function conservationPrograms()
    {
        return $this->hasMany(FaunaConservationProgram::class);
    }

    public function threats()
    {
        return $this->hasMany(FaunaThreat::class);
    }
}