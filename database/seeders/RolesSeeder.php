<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
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
    }
}
