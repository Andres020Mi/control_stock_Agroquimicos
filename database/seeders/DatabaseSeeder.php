<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            InsumosTableSeeder::class,
            AlmacenesTableSeeder::class,
            ProveedoresTableSeeder::class,
            StocksTableSeeder::class,
            UnidadesDeProduccionTableSeeder::class,
            MovimientosTableSeeder::class,
            InsumoUnidadDeProduccionTableSeeder::class,
        ]);
    }
}
