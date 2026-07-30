<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    use HasFactory;

    protected $fillable = ['class_name', 'slug', 'kingdom', 'phylum', 'order', 'family'];

    public function faunas()
    {
        return $this->hasMany(Fauna::class);
    }
}
