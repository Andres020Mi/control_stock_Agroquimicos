<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // Cambia esto por una contraseña segura
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Aprendiz User',
            'email' => 'aprendiz@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'aprendiz',
        ]);

        User::create([
            'name' => 'Instructor User',
            'email' => 'instructor@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
        ]);

        User::create([
            'name' => 'Lider de la unidad',
            'email' => 'liderUnidad@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'lider de la unidad',
        ]);
    }
}
