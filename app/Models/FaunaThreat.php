<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaunaThreat extends Model
{
    use HasFactory;

    protected $fillable = [
        'fauna_id',
        'icon',
        'title',
        'description',
    ];

    public function fauna()
    {
        return $this->belongsTo(Fauna::class);
    }
}
