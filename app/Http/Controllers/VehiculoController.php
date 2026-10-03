<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Response\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VehiculoController extends Controller
{
    public function index()
    {
        try {
            $vehiculos = Vehiculo::paginate(10);
            return ApiResponse::success('Listado de vehículos', 200, $vehiculos);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al obtener los vehículos: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $vehiculo = Vehiculo::find($id);

            if (!$vehiculo) {
                return ApiResponse::error('Vehículo no encontrado', 404);
            }

            return ApiResponse::success('Vehículo encontrado', 200, $vehiculo);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al buscar el vehículo: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $messages = [
                'numero_vin.required' => 'El número VIN es requerido',
                'numero_vin.unique' => 'Ya existe un vehículo con ese número VIN',
                'numero_vin.size' => 'El número VIN debe tener exactamente 17 caracteres',
                'placa.required' => 'La placa es requerida',
                'placa.unique' => 'Ya existe un vehículo con esa placa',
                'marca.required' => 'La marca es requerida',
                'modelo.required' => 'El modelo es requerido',
                'anio.required' => 'El año es requerido',
                'anio.digits' => 'El año debe tener 4 dígitos',
                'kilometraje_actual.min' => 'El kilometraje no puede ser negativo',
            ];

            $validator = Validator::make($request->all(), [
                'numero_vin' => 'required|string|size:17|unique:vehiculos,numero_vin',
                'placa' => 'required|string|unique:vehiculos,placa',
                'marca' => 'required|string|max:255',
                'modelo' => 'required|string|max:255',
                'anio' => 'required|digits:4',
                'kilometraje_actual' => 'required|integer|min:0',
            ], $messages);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors()->first(), 422);
            }

            DB::beginTransaction();

            $vehiculo = Vehiculo::create($request->all());

            DB::commit();

            return ApiResponse::success('Vehículo creado correctamente', 201, $vehiculo);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Error al crear el vehículo: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $vehiculo = Vehiculo::find($id);

            if (!$vehiculo) {
                return ApiResponse::error('Vehículo no encontrado', 404);
            }

            $vehiculo->delete();

            return ApiResponse::success('Vehículo eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            return ApiResponse::error('No se puede eliminar: el vehículo tiene servicios de mantenimiento asociados', 409);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al eliminar el vehículo: ' . $e->getMessage());
        }
    }
}