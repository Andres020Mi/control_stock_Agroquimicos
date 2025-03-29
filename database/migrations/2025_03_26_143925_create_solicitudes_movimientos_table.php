<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesMovimientosTable extends Migration
{
    public function up()
    {
        Schema::create('solicitudes_movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->comment('Usuario que solicita el cambio');
            $table->foreignId('movimiento_id')
                  ->constrained('movimientos')
                  ->onDelete('cascade')
                  ->comment('Movimiento al que se aplica la solicitud');
            $table->enum('tipo', ['editar', 'eliminar'])
                  ->comment('Tipo de solicitud: editar o eliminar');
            $table->json('datos_nuevos')
                  ->nullable()
                  ->comment('Datos propuestos para la edición (solo para solicitudes de tipo "editar")');
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada','cancelada'])
                  ->default('pendiente')
                  ->comment('Estado de la solicitud');
            $table->foreignId('aprobador_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->comment('Usuario que aprueba o rechaza la solicitud (admin o instructor)');
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->text('motivo_rechazo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes_movimientos');
    }
}