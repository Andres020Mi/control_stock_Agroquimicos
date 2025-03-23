<?php

namespace Database\Seeders;

use App\Models\unidades_de_produccion;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class UnidadesDeProduccionTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            unidades_de_produccion::create([
                'nombre' => 'Unidad ' . ($i + 1),
                'descripcion' => $faker->paragraph,
            ]);
        }
    }
}