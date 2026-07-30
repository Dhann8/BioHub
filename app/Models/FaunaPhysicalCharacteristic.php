<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaunaPhysicalCharacteristic extends Model
{
    use HasFactory;

    protected $fillable = [
        'fauna_id',
        'size_and_weight',
        'distinctive_features',
    ];

    public function fauna()
    {
        return $this->belongsTo(Fauna::class);
    }
}
