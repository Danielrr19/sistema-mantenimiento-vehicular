<?php

namespace Database\Seeders;

use App\Models\ServicioMantenimiento;
use App\Models\Taller;
use App\Models\Vehiculo;
use Illuminate\Database\Seeder;

class ServicioMantenimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ServicioMantenimiento::factory()
        ->count(30)
        ->create([
            'vehiculo_id' => fn () =>Vehiculo::inRandomOrder()->first()->id,
            'taller_id' => fn () => Taller::inRandomOrder()->first()->id,
        ]);
    }
}
