<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';
    protected $fillable = ['id_insumo', 'cantidad', 'fecha_de_vencimiento', 'id_almacen', 'estado'];

    // Relationship with Insumo
    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'id_insumo');
    }

    // Relationship with Almacen
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen');
    }
}