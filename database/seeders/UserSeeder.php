<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador
        Usuario::create([
            'username' => 'admin',
            'nombre' => 'Administrador',
            'apellido' => 'Sistema',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'biografia' => 'Administrador del sistema',
            'rol' => 'admin',
            'estado' => 'activo',
            'remember_token' => null,
            'avatar' => null,
        ]);

        // Crear 10 usuarios regulares
        for ($i = 1; $i <= 10; $i++) {
            Usuario::create([
                'username' => 'usuario' . $i,
                'nombre' => 'Usuario ' . $i,
                'apellido' => 'Apellido ' . $i,
                'email' => 'usuario' . $i . '@example.com',
                'password' => Hash::make('password'),
                'biografia' => 'Biografía del usuario ' . $i,
                'rol' => 'usuario',
                'estado' => 'activo',
                'remember_token' => null,
                'avatar' => null,
            ]);
        }
    }
}