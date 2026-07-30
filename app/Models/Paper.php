<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Cast kolom compounds biar otomatis jadi Array JS/PHP
    protected $casts = [
        'compounds' => 'array',
    ];
}