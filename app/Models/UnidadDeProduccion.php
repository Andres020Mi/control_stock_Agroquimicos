<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadDeProduccion extends Model
{
    protected $fillable = ['nombre', 'descripcion'];

    // Relación: Una unidad de producción puede tener varios líderes
    public function lideres()
    {
        return $this->belongsToMany(User::class, 'lideres_unidades', 'unidad_de_produccion_id', 'user_id')
                    ->withTimestamps();
    }
}