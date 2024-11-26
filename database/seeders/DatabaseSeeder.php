<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\RolUsuario;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        //Usuarios
        User::factory(15)->create();
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => '12345'
        ]);
        User::create([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => '12345'
        ]);
        //Roles
        Rol::create([
            'name' => 'Administrador',
            'slug' => 'administrador' ,
            'description' => now(),
            'created_at' => now()
        ]);
        Rol::create([
            'name' => 'Usuario',
            'slug' => 'usuario' ,
            'description' => now(),
            'created_at' => now()
        ]);

        //Admin
        RolUsuario::create([
            'user_id' => 'admin@example.com',
            'role_id' => 1,
            'created_at' => now()
        ]);
        //Usuario
        RolUsuario::create([
            'user_id' => 'user@example.com',
            'role_id' => 2,
            'created_at' => now()
        ]);


    }
}
