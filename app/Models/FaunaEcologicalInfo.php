<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaunaEcologicalInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'fauna_id',
        'habitat_description',
        'diet_and_behavior',
        'quote',
    ];

    public function fauna()
    {
        return $this->belongsTo(Fauna::class);
    }
}
