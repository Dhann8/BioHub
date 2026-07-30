<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaunaGallery extends Model
{
    use HasFactory;

    protected $table = 'fauna_galleries';

    protected $fillable = [
        'fauna_id',
        'image_url',
        'caption',
    ];

    public function fauna()
    {
        return $this->belongsTo(Fauna::class);
    }
}
