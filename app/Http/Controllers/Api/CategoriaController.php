<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //consultar todos los registro que existen en la tabla categorias 
        return Categoria::query()
        ->withCount('productos') 
        ->orderBy('id','desc')
        ->paginate(10); // Paginación de 10 en 10
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validar la data que nos envia el cliente 
        $data = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
            'descripcion' => 'nullable|string',
            'activa' => 'boolean',
        ]);
        // agregar a crear el registro como tal en la base de datos 
        $categoria = Categoria::create($data);
        //devolver una respuesta al cliente
        return response()->json($categoria); 
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $Categoria)

    {
        return $Categoria->load('productos');
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $Categoria)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,'.$Categoria->id,
            'descripcion' => 'nullable|string',
            'activa' => 'boolean',
        ]);

        $Categoria->update($data);
        return response()->json($Categoria);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($Categoria)
    {
        $cat=Categoria::find($Categoria);
        $cat->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
