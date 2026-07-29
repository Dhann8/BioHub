<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    use HasFactory;

    protected $fillable = ['class_name','slug'];

    // Relasi 1-to-Many: 1 Kategori Taksonomi memiliki Banyak Satwa (Fauna)
    public function faunas()
    {
        return $this->hasMany(Fauna::class);
    }
}
