<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    /** @use HasFactory<\Database\Factories\TallerFactory> */
    use HasFactory;

    protected $table = 'talleres';
    protected $fillable = [
        'nombre',
        'telefono',
        'direccion',
        'esta_activo',
    ];

    // Un taller puede tener muchos servicios de mantenimiento
    public function servicios()
    {
        return $this->hasMany(ServicioMantenimiento::class, 'taller_id');
    }
}
