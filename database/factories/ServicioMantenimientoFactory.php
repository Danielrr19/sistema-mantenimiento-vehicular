<?php

namespace Database\Factories;

use App\Models\Taller;
use App\Models\Vehiculo;
use App\Models\ServicioMantenimiento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ServicioMantenimiento>
 */
class ServicioMantenimientoFactory extends Factory
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
            'vehiculo_id' => Vehiculo::factory(),
            'taller_id' => Taller::factory(),
            'fecha_servicio' => fake()->dateTimeBetween('-1 year', 'now'),
            'kilometraje_servicio' => fake()->numberBetween(0, 200000),
            'costo_total' => fake()->randomFloat(2, 50, 1500),
            'estado' => fake()->randomElement(['pendiente', 'en_proceso', 'cancelado']),
        ];
    }
}
