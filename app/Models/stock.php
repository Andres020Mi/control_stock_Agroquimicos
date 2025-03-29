<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';
    protected $fillable = [
        'id_insumo',
        'cantidad',
        'cantidad_inicial',
        'fecha_de_vencimiento',
        'id_almacen',
        'id_proveedor',
        'estado',
    ];

    protected $casts = [
        'fecha_de_vencimiento' => 'date',
    ];

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'id_insumo');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

}