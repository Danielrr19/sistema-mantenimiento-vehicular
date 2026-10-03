<?php

namespace App\Http\Controllers;

use App\Models\ServicioMantenimiento;
use App\Response\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServicioMantenimientoController extends Controller
{
    public function index()
    {
        try {
            // with() carga también el vehículo y taller relacionados en la misma respuesta
            $servicios = ServicioMantenimiento::with(['vehiculo', 'taller'])->paginate(10);
            return ApiResponse::success('Listado de servicios de mantenimiento', 200, $servicios);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al obtener los servicios: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $servicio = ServicioMantenimiento::with(['vehiculo', 'taller', 'detalles'])->find($id);

            if (!$servicio) {
                return ApiResponse::error('Servicio no encontrado', 404);
            }

            return ApiResponse::success('Servicio encontrado', 200, $servicio);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al buscar el servicio: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $messages = [
                'vehiculo_id.required' => 'El vehículo es requerido',
                'vehiculo_id.exists' => 'El vehículo no existe',
                'taller_id.required' => 'El taller es requerido',
                'taller_id.exists' => 'El taller no existe',
                'fecha_servicio.required' => 'La fecha de servicio es requerida',
                'kilometraje_servicio.min' => 'El kilometraje no puede ser negativo',
                'estado.in' => 'El estado debe ser: pendiente, en_proceso, completado o cancelado',
            ];

            $validator = Validator::make($request->all(), [
                'vehiculo_id' => 'required|exists:vehiculos,id',
                'taller_id' => 'required|exists:talleres,id',
                'fecha_servicio' => 'required|date',
                'kilometraje_servicio' => 'required|integer|min:0',
                'costo_total' => 'required|numeric|min:0',
                'estado' => 'required|in:pendiente,en_proceso,completado,cancelado',
            ], $messages);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors()->first(), 422);
            }

            DB::beginTransaction();

            $servicio = ServicioMantenimiento::create($request->all());

            DB::commit();

            return ApiResponse::success('Servicio creado correctamente', 201, $servicio);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Error al crear el servicio: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $servicio = ServicioMantenimiento::find($id);

            if (!$servicio) {
                return ApiResponse::error('Servicio no encontrado', 404);
            }

            // Aquí SÍ se borra sin problema: sus detalles se eliminan automáticamente (cascade)
            $servicio->delete();

            return ApiResponse::success('Servicio eliminado correctamente (y sus detalles asociados)');
        } catch (\Exception $e) {
            return ApiResponse::error('Error al eliminar el servicio: ' . $e->getMessage());
        }
    }
}