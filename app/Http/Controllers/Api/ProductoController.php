<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Consultar todos los productos con su categoría asociada
        return Producto::query()
            ->with('categoria') // Cargar relación
            ->orderBy('id', 'desc')
            ->paginate(10); // Paginación de 10 en 10
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos que envía el cliente
        $data = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255|unique:productos,nombre',
            'sku' => 'nullable|string|max:100|unique:productos,sku',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'activa' => 'boolean',
        ]);

        // Crear el producto
        $producto = Producto::create($data);

        // Devolver respuesta al cliente
        return response()->json($producto, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        // Mostrar un producto con su categoría asociada
        return $producto->load('categoria');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        // Validar los datos actualizados
        $data = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255|unique:productos,nombre,' . $producto->id,
            'sku' => 'nullable|string|max:100|unique:productos,sku,' . $producto->id,
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'activa' => 'boolean',
        ]);

        // Actualizar el producto
        $producto->update($data);

        // Devolver la respuesta
        return response()->json($producto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
