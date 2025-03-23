<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Almacen;
use Faker\Factory as Faker;

class AlmacenesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            Almacen::create([
                'nombre' => 'Almacén ' . ($i + 1),
                'descripcion' => $faker->sentence,
            ]);
        }
    }
}