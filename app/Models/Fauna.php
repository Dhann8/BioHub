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
    ];

    protected $casts = [
        'physical_features' => 'array',
    ];

    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
    }

    public function locations()
    {
        return $this->hasMany(FaunaLocation::class);
    }
}