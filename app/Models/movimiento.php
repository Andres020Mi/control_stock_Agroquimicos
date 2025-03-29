<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';
    protected $fillable = [
        'id_user',
        'tipo',
        'id_stock',
        'cantidad',
        'id_unidad_de_produccion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'id_stock');
    }

    public function unidadDeProduccion()
    {
        return $this->belongsTo(unidades_de_produccion::class, 'id_unidad_de_produccion');
    }
}