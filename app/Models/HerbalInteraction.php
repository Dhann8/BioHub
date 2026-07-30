<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HerbalInteraction extends Model
{
    use HasFactory;

    protected $fillable = ['herbal_id', 'title', 'description', 'severity'];

    public function herbal()
    {
        return $this->belongsTo(Herbal::class);
    }
}
