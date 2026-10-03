<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioMantenimiento extends Model
{
    /** @use HasFactory<\Database\Factories\ServicioMantenimientoFactory> */
    use HasFactory;

    protected $table = 'servicios_mantenimiento';
    protected $fillable = [
        'vehiculo_id',
        'taller_id',
        'fecha_servicio',
        'kilometraje_servicio',
        'costo_total',
        'estado',
    ];

    // Un servicio pertenece a un vehiculo
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }

    // Un servicio pertenece a un taller
    public function taller()
    {
        return $this->belongsTo(Taller::class, 'taller_id');
    }

    //Un servicio puede tener muchos detalles de servicio
    public function detalles()
    {
        return $this->hasMany(DetalleServicio::class, 'servicio_mantenimiento_id');
    }
}
