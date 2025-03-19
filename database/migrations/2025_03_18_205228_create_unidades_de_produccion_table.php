
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadesDeProduccionTable extends Migration
{
    public function up()
    {
        Schema::create('unidades_de_produccion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        // Pivot table to link production units with insumos
        Schema::create('insumo_unidad_de_produccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_insumo')->constrained('insumos')->onDelete('cascade');
            $table->foreignId('id_unidad_de_produccion')->constrained('unidades_de_produccion')->onDelete('cascade');
            $table->integer('cantidad')->default(0); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('insumo_unidad_de_produccion');
        Schema::dropIfExists('unidades_de_produccion');
    }
}