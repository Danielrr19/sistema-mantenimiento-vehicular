<?php

namespace App\Http\Controllers;

use App\Models\Taller;
use App\Response\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TallerController extends Controller
{
    // Listar todos los talleres
    public function index()
    {
        try {
            $talleres = Taller::paginate(10);
            return ApiResponse::success('Listado de talleres', 200, $talleres);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al obtener los talleres: ' . $e->getMessage());
        }
    }

    // Consultar un taller por su id
    public function show($id)
    {
        try {
            $taller = Taller::find($id);

            if (!$taller) {
                return ApiResponse::error('Taller no encontrado', 404);
            }

            return ApiResponse::success('Taller encontrado', 200, $taller);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al buscar el taller: ' . $e->getMessage());
        }
    }

    // Crear un nuevo taller
    public function store(Request $request)
    {
        try {
            $messages = [
                'nombre.required' => 'El nombre es requerido',
                'nombre.string' => 'El nombre debe ser texto',
                'telefono.required' => 'El teléfono es requerido',
                'esta_activo.boolean' => 'El estado activo debe ser verdadero o falso',
            ];

            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'telefono' => 'required|string|max:255',
                'direccion' => 'nullable|string',
                'esta_activo' => 'nullable|boolean',
            ], $messages);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors()->first(), 422);
            }

            DB::beginTransaction();

            $taller = Taller::create($request->all());

            DB::commit();

            return ApiResponse::success('Taller creado correctamente', 201, $taller);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Error al crear el taller: ' . $e->getMessage());
        }
    }

    // Eliminar un taller (respetando integridad referencial)
    public function destroy($id)
    {
        try {
            $taller = Taller::find($id);

            if (!$taller) {
                return ApiResponse::error('Taller no encontrado', 404);
            }

            $taller->delete();

            return ApiResponse::success('Taller eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            // Postgres bloquea el borrado por la regla "restrict" si tiene servicios asociados
            return ApiResponse::error('No se puede eliminar: el taller tiene servicios de mantenimiento asociados', 409);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al eliminar el taller: ' . $e->getMessage());
        }
    }
}