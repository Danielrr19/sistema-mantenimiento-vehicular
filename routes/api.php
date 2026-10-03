<?php

use App\Http\Controllers\DetalleServicioController;
use App\Http\Controllers\ServicioMantenimientoController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\TallerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('talleres', TallerController::class);
Route::apiResource('vehiculos', VehiculoController::class);
Route::apiResource('servicios-mantenimiento', ServicioMantenimientoController::class);
Route::apiResource('detalles-servicio', DetalleServicioController::class);
