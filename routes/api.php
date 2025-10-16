<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ProductoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// DECLARAR RUTAS DE CATEGORIAS 
//Route::apiResource('categorias', CategoriaController::class);
Route::get('consultar-todas-categorias', [CategoriaController::class, 'index']);
Route::get('consultar-una-categoria/{Categoria}', [CategoriaController::class, 'show']);
Route::post('guardar-categoria', [CategoriaController::class, 'store']);
Route::put('actualizar-categoria/{Categoria}', [CategoriaController::class, 'update']);
Route::delete('eliminar-categoria/{Categoria}', [CategoriaController::class, 'destroy']);

// DECLARAR RUTAS DE PRODUCTOS 
Route::get('consultar-todos-productos', [ProductoController::class, 'index']);
Route::get('consultar-un-productos/{producto}', [ProductoController::class, 'show']);
Route::post('guardar-productos', [ProductoController::class, 'store']);
Route::put('actualizar-productos/{producto}', [ProductoController::class, 'update']);
Route::delete('eliminar-productos/{producto}', [ProductoController::class,'destroy']);