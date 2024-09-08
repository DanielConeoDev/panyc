<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = ['fuente_id', 'grupo', 'descripcion'];

    public function fuente()
    {
        return $this->belongsTo(Fuente::class);
    }

    public function alimentos()
    {
        return $this->hasMany(Alimento::class);
    }
}
