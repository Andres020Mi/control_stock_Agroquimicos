<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Insumo;
use Faker\Factory as Faker;

class InsumosTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Insumo::create([
                'nombre' => $faker->word . ' Agroquímico',
                'composicion_quimica' => $faker->randomElement(['Nitrato de Amonio', 'Cloruro de Potasio', 'Fosfato Diamónico']),
                'unidad_de_medida' => $faker->randomElement(['kg', 'g', 'l', 'ml']),
                'imagen' => "insumos/productDefec.png",
            ]);
        }
    }
}