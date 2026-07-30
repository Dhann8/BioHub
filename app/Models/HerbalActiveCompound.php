<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HerbalActiveCompound extends Model
{
    use HasFactory;

    protected $fillable = ['herbal_id', 'compound_name', 'pharmacological_effect'];

    public function herbal()
    {
        return $this->belongsTo(Herbal::class);
    }
}
