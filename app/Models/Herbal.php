<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Herbal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'local_name',
        'scientific_name',
        'plant_family',
        'origin_region',
        'description',
        'morphology_description',
        'plant_parts',
        'cultivation_zone',
        'preparation_method',
        'dosage_guide',
        'safety_warning',
        'evidence_level',
        'image_url',
        'map_image_url',
    ];

    protected $casts = [
        'plant_parts' => 'array',
    ];

    public function getImageUrlAttribute($value)
    {
        if (!$value) return null;
        if (filter_var($value, FILTER_VALIDATE_URL)) return $value;
        return asset(ltrim($value, '/'));
    }

    public function getMapImageUrlAttribute($value)
    {
        if (!$value) return null;
        if (filter_var($value, FILTER_VALIDATE_URL)) return $value;
        return asset(ltrim($value, '/'));
    }

    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class, 'herbal_symptom')
                    ->withPivot('plant_part_used')
                    ->withTimestamps();
    }

    public function activeCompounds()
    {
        return $this->hasMany(HerbalActiveCompound::class);
    }

    public function gallery()
    {
        return $this->hasMany(HerbalGallery::class);
    }

    public function interactions()
    {
        return $this->hasMany(HerbalInteraction::class);
    }
}