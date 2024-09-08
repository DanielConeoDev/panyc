<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parte extends Model
{
    use HasFactory;

    protected $fillable = ['parte', 'descripcion'];

    public function alimentos()
    {
        return $this->hasMany(Alimento::class);
    }
}
