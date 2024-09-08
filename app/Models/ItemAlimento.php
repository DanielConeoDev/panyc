<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemAlimento extends Model
{
    use HasFactory;

    protected $fillable = ['alimento_id', 'tipo_id', 'componente_id', 'valor'];

    public function alimento()
    {
        return $this->belongsTo(Alimento::class);
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }
}
