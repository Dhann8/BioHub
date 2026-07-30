<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory;

    protected $fillable = [
        'symptom_name',
        'icon_svg',
    ];


    public function herbals()
    {
        return $this->belongsToMany(Herbal::class, 'herbal_symptom')
                    ->withPivot('plant_part_used')
                    ->withTimestamps();
    }
}