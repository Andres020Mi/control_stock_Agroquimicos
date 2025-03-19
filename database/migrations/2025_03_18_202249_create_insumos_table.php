<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumosTable extends Migration
{
    public function up()
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('composicion_quimica');
            $table->enum('unidad_de_medida',['kg','g','l','ml']); // e.g., litros, kg, etc.
            $table->string('imagen')->nullable(); // Path to the image
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('insumos');
    }
}