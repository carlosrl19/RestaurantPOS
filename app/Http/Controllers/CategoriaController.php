<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // Index
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categorias = Categoria::query()
            ->when($search, function ($query, $search) {
                return $query->where('nombre_Categoria', 'LIKE', '%' . $search . '%');
            })
            ->orderBy('nombre_Categoria')
            ->paginate(10);

        return view('modules.categorias.index', compact('categorias', 'search'));
    }

    // Crear categoría
    public function store(Request $request)
    {
        $request->validate([
            'nombre_Categoria' => 'required|string|max:255|unique:categorias,nombre_Categoria',
        ]);
    
        $categoria = new Categoria();
        $categoria->nombre_Categoria = $request->nombre_Categoria;
        $categoria->save();
    
        return redirect()->route('categorias.index')->with('success', 'Categoría creada con éxito.');
    }
    
    // Actualizar categoría
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre_Categoria' => 'required|string|max:255|unique:categorias,nombre_Categoria,' . $categoria->id,
        ]);
    
        $categoria->nombre_Categoria = $request->nombre_Categoria;
        $categoria->save();
    
        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada con éxito.');
    }
    
    
    // Eliminar categoría
    public function destroy($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
    
            if ($categoria->productos()->count() > 0) {
                return redirect()->route('categorias.index')
                    ->with('error', 'No se puede eliminar. Hay productos asociados a esta categoría.');
            }
    
            $categoria->delete();
    
            return redirect()->route('categorias.index')->with('success', 'Categoría eliminada con éxito.');
        } catch (\Exception $e) {
            return redirect()->route('categorias.index')->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }    
}

