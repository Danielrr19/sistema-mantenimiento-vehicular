<?php

namespace App\Http\Controllers;

use App\Models\DetalleServicio;
use App\Response\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DetalleServicioController extends Controller
{
    public function index()
    {
        try {
            $detalles = DetalleServicio::with('servicioMantenimiento')->paginate(10);
            return ApiResponse::success('Listado de detalles de servicio', 200, $detalles);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al obtener los detalles: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $detalle = DetalleServicio::find($id);

            if (!$detalle) {
                return ApiResponse::error('Detalle no encontrado', 404);
            }

            return ApiResponse::success('Detalle encontrado', 200, $detalle);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al buscar el detalle: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $messages = [
                'servicio_mantenimiento_id.required' => 'El servicio de mantenimiento es requerido',
                'servicio_mantenimiento_id.exists' => 'El servicio de mantenimiento no existe',
                'descripcion.required' => 'La descripción es requerida',
                'tipo.in' => 'El tipo debe ser: mano_obra o repuesto',
                'cantidad.min' => 'La cantidad debe ser al menos 1',
            ];

            $validator = Validator::make($request->all(), [
                'servicio_mantenimiento_id' => 'required|exists:servicios_mantenimiento,id',
                'descripcion' => 'required|string|max:255',
                'tipo' => 'required|in:mano_obra,repuesto',
                'cantidad' => 'required|integer|min:1',
                'costo_unitario' => 'required|numeric|min:0',
                'subtotal' => 'required|numeric|min:0',
            ], $messages);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors()->first(), 422);
            }

            DB::beginTransaction();

            $detalle = DetalleServicio::create($request->all());

            DB::commit();

            return ApiResponse::success('Detalle creado correctamente', 201, $detalle);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Error al crear el detalle: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $detalle = DetalleServicio::find($id);

            if (!$detalle) {
                return ApiResponse::error('Detalle no encontrado', 404);
            }

            $detalle->delete();

            return ApiResponse::success('Detalle eliminado correctamente');
        } catch (\Exception $e) {
            return ApiResponse::error('Error al eliminar el detalle: ' . $e->getMessage());
        }
    }
}