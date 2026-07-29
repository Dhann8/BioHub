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
        'description',
        'preparation_method',
        'dosage_guide',
        'safety_warning',
        'evidence_level',
        'image_url',
    ];

    /**
     * Relasi Many-to-Many: Herbal mengobati banyak Gejala (Symptom).
     */
    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class, 'herbal_symptom')
                    ->withPivot('plant_part_used')
                    ->withTimestamps();
    }
}