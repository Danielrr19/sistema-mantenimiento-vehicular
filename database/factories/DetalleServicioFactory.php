<?php

namespace Database\Factories;

use App\Models\ServicioMantenimiento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DetalleServicio>
 */
class DetalleServicioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cantidad = fake()->numberBetween(1, 5);
        $costoUnitario = fake()->randomFloat(2, 5, 100);

        return [
            //
            'servicio_mantenimiento_id' => ServicioMantenimiento::factory(),
            'descripcion' => fake()->randomElement([
                'Cambio de aceite',
                'Revisión de frenos',
                'Mano de obra',
                'Alineación y balanceo',
                'Revisión de frenos',
                'Cambio de bujías',
                'Lavado y encerado',
            ]),
            'tipo' => fake()->randomElement(['mano_obra', 'repuesto']),
            'cantidad' => $cantidad,
            'costo_unitario' => $costoUnitario,
            'subtotal' => $cantidad * $costoUnitario,
        ];
    }
}
