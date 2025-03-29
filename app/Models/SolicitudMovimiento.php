<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudMovimiento extends Model
{
    protected $table = 'solicitudes_movimientos';
    protected $fillable = [
        'user_id',
        'movimiento_id',
        'tipo',
        'datos_nuevos',
        'estado',
        'aprobador_id',
        'fecha_aprobacion',
        'motivo_rechazo',
    ];

    protected $casts = [
        'datos_nuevos' => 'array',
        'fecha_aprobacion' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'movimiento_id');
    }

    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobador_id');
    }
    
}