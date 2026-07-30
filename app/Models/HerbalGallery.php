<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HerbalGallery extends Model
{
    use HasFactory;

    protected $fillable = ['herbal_id', 'image_url', 'caption'];

    public function herbal()
    {
        return $this->belongsTo(Herbal::class);
    }
}
