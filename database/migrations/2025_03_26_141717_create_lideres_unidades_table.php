<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLideresUnidadesTable extends Migration
{
    public function up()
    {
        Schema::create('lideres_unidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->comment('Usuario que actúa como líder de la unidad');
            $table->foreignId('unidad_de_produccion_id')
                  ->constrained('unidades_de_produccion')
                  ->onDelete('cascade')
                  ->comment('Unidad de producción asignada al líder');
            $table->timestamps();

            // Índice único para evitar asignaciones duplicadas (un usuario no puede ser líder de la misma unidad más de una vez)
            $table->unique(['user_id', 'unidad_de_produccion_id'], 'lideres_unidades_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lideres_unidades');
    }
}