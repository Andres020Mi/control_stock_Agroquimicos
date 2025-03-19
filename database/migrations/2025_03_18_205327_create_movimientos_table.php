
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientosTable extends Migration
{
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); // Assuming a users table exists
            $table->enum('tipo', ['entrada', 'salida']); // Input or output
            $table->foreignId('id_stock')->constrained('stocks')->onDelete('cascade');
            $table->integer('cantidad'); // Amount moved
            $table->foreignId('id_unidad_de_produccion')->nullable()->constrained('unidades_de_produccion')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimientos');
    }
}





