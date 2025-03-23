<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_insumo')->constrained('insumos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->integer('cantidad_inicial'); 
            $table->date('fecha_de_vencimiento');
            $table->foreignId('id_almacen')->constrained('almacenes')->onDelete('cascade');
            $table->enum('estado',['caducado','utilizable','agotado'])->default('utilizable');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}