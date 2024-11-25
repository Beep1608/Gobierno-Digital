<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        User::factory(15)->create();
        User::create([
            'name' => 'fidel',
            'email' => 'fidel@example.com',
            'password' => '12345'
        ]);


    }
}
