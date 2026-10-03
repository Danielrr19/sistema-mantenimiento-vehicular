<?php

namespace Database\Seeders;

use App\Models\DetalleServicio;
use App\Models\ServicioMantenimiento;
use Illuminate\Database\Seeder;

class DetalleServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ServicioMantenimiento::all()->each(function ($servicio) {
            DetalleServicio::factory()
            ->count(rand(1, 4))
            ->create(['servicio_mantenimiento_id' => $servicio->id]);
        });
    }
}
