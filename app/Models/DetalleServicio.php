<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleServicio extends Model
{
    /** @use HasFactory<\Database\Factories\DetalleServicioFactory> */
    use HasFactory;

    protected $table = 'detalles_servicio';
    protected $fillable = [
        'servicio_mantenimiento_id',
        'descripcion',
        'tipo',
        'cantidad',
        'costo_unitario',
        'subtotal',
    ];

    // Un detalle de servicio pertenece a un servicio de mantenimiento
    public function servicioMantenimiento()
    {
        return $this->belongsTo(ServicioMantenimiento::class, 'servicio_mantenimiento_id');
    }
}
