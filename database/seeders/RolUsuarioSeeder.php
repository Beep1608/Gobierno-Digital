<?php

namespace Database\Seeders;

use App\Models\RolUsuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        //Admin
        RolUsuario::create([
            'user_id' => 'fidel@example.com',
            'role_id' => 1,
            'created_at' => now()
        ]);
        //Usuario
       
    }
}
