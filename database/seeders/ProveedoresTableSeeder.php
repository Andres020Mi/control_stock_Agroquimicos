<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;
use Faker\Factory as Faker;

class ProveedoresTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            Proveedor::create([
                'nombre' => $faker->company,
                'nit' => $faker->unique()->numerify('NIT-#####'),
                'telefono' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'direccion' => $faker->address,
            ]);
        }
    }
}