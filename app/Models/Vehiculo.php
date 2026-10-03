<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    /** @use HasFactory<\Database\Factories\VehiculoFactory> */
    use HasFactory;

    protected $table = 'vehiculos';
    protected $fillable = [
        'numero_vin',
        'placa',
        'marca',
        'modelo',
        'anio',
        'kilometraje_actual',
    ];

    // Un vehiculo puede tiene muchos servicios de mantenimiento
    public function servicios()
    {
        return $this->hasMany(ServicioMantenimiento::class, 'vehiculo_id');
    }
}
