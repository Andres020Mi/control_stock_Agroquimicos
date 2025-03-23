<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdProveedorToStocksTable extends Migration
{
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->foreignId('id_proveedor')
                  ->nullable()
                  ->constrained('proveedores')
                  ->onDelete('set null')
                  ->after('id_almacen');
        });
    }

    public function down()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropForeign(['id_proveedor']);
            $table->dropColumn('id_proveedor');
        });
    }
}