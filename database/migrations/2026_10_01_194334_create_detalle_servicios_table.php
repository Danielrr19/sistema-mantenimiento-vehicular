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
        Schema::create('detalles_servicio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_mantenimiento_id')->constrained('servicios_mantenimiento')->cascadeOnDelete();
            $table->string('descripcion');
            $table->enum('tipo', ['mano_obra', 'repuesto']);
            $table->unsignedBigInteger('cantidad');
            $table->decimal('costo_unitario', 8, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_servicio');
    }
};
