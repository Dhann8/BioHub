<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaunaLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'fauna_id',
        'region_name',
        'latitude',
        'longitude',
    ];

    /**
     * Relasi BelongsTo: Lokasi terhubung ke satu Fauna.
     */
    public function fauna()
    {
        return $this->belongsTo(Fauna::class);
    }
}