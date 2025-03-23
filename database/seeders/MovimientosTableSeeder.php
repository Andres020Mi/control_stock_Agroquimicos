<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movimiento;
use App\Models\Stock;
use App\Models\User;
use App\Models\unidades_de_produccion;
use Faker\Factory as Faker;

class MovimientosTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $stocks = Stock::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();
        $unidades = unidades_de_produccion::pluck('id')->toArray();

        for ($i = 0; $i < 15; $i++) {
            Movimiento::create([
                'id_user' => $faker->randomElement($users),
                'tipo' => $faker->randomElement(['entrada', 'salida']),
                'id_stock' => $faker->randomElement($stocks),
                'cantidad' => $faker->numberBetween(1, 50),
                'id_unidad_de_produccion' => $faker->randomElement([null, ...$unidades]), // Algunos sin unidad
            ]);
        }
    }
}