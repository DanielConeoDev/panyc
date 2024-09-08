<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    use HasFactory;

    protected $fillable = ['tipo_id', 'componente', 'descripcion'];

    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function item_alimentos()
    {
        return $this->hasMany(ItemAlimento::class);
    }
}
