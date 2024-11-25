<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RolUsuario>
 */
class RolUsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'user_id' =>fake()->unique()->safeEmail(),
            'role_id' =>fake()->unique()->name(),
            'created_at' => now(),
            'updated_at' => null,
        ];
    }
}
