<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuente extends Model
{
    use HasFactory;

    protected $fillable = [
        'fuente',
        'descripcion',
        'año',
        'pais_id',
        'url',
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }

    public function grupos()
    {
        return $this->hasMany(Grupo::class);
    }

    

}
