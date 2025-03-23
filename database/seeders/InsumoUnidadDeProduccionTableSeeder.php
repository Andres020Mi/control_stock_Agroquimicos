<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Insumo;
use App\Models\unidades_de_produccion;
use Faker\Factory as Faker;

class InsumoUnidadDeProduccionTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $insumos = Insumo::pluck('id')->toArray();
        $unidades = unidades_de_produccion::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            DB::table('insumo_unidad_de_produccion')->insert([
                'id_insumo' => $faker->randomElement($insumos),
                'id_unidad_de_produccion' => $faker->randomElement($unidades),
                'cantidad' => $faker->numberBetween(0, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}