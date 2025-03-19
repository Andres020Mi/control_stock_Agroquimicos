<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table = 'insumos';
    protected $fillable = ['nombre', 'composicion_quimica', 'unidad_de_medida', 'imagen'];
}