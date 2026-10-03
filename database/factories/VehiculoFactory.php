<?php

namespace Database\Factories;

use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehiculo>
 */
class VehiculoFactory extends Factory
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
            'numero_vin' => strtoupper(fake()->bothify('?????????????????')),
            'placa' => strtoupper(fake()->bothify('???-###')),
            'marca' => fake()->randomElement(['Toyota', 'Nissan', 'Ford', 'Kia', 'Hyundai']),
            'modelo' => fake()->word(),
            'anio' => fake()->numberBetween(2010, 2024),
            'kilometraje_actual' => fake()->numberBetween(0, 200000),       
        ];
    }
}
