<?php

namespace Database\Factories;

use App\Models\Taller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Taller>
 */
class TallerFactory extends Factory
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
            'nombre' => fake()->company(),
            'telefono' => fake()->phoneNumber(),
            'direccion' => fake()->address(),
            'esta_activo' =>fake()->boolean(90),
        ];
    }
}
