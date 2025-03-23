<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;
use App\Models\Insumo;
use App\Models\Almacen;
use App\Models\Proveedor;
use Faker\Factory as Faker;

class StocksTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $insumos = Insumo::pluck('id')->toArray();
        $almacenes = Almacen::pluck('id')->toArray();
        $proveedores = Proveedor::pluck('id')->toArray();

        for ($i = 0; $i < 20; $i++) {
            $cantidad = $faker->numberBetween(1, 100);
            Stock::create([
                'id_insumo' => $faker->randomElement($insumos),
                'cantidad' => $cantidad,
                'cantidad_inicial' => $cantidad, // Asignamos el mismo valor que cantidad como punto de partida
                'fecha_de_vencimiento' => $faker->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
                'id_almacen' => $faker->randomElement($almacenes),
                'id_proveedor' => $faker->randomElement([null, ...$proveedores]), // Algunos sin proveedor
                'estado' => $faker->randomElement(['caducado', 'utilizable', 'agotado']),
            ]);
        }
    }
}