<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;

    protected $fillable = ['tipo', 'descripcion'];

    public function componentes()
    {
        return $this->hasMany(Componente::class);
    }

    public function item_alimentos()
    {
        return $this->hasMany(ItemAlimento::class);
    }
}
