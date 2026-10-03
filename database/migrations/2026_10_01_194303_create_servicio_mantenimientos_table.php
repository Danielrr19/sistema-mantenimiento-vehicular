<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('servicios_mantenimiento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->restrictOnDelete();
            $table->foreignId('taller_id')->constrained('talleres')->restrictOnDelete();
            $table->dateTime('fecha_servicio');
            $table->unsignedInteger('kilometraje_servicio');
            $table->decimal('costo_total', 10, 2);
            $table->enum('estado', ['pendiente', 'en_proceso', 'completado', 'cancelado']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios_mantenimiento');
    }
};
