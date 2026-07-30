<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaunaConservationProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'fauna_id',
        'title_or_description',
    ];

    public function fauna()
    {
        return $this->belongsTo(Fauna::class);
    }
}
