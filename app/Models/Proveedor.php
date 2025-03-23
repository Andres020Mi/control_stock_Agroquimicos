<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $fillable = ['nombre', 'nit', 'telefono', 'email', 'direccion'];

    // Especificar el nombre de la tabla
    protected $table = 'proveedores';
}