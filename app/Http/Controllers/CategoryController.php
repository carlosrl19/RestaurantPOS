<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categories\StoreRequest;
use App\Http\Requests\Categories\UpdateRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categorias = Categoria::get();
        return view('modules.categories.index', compact('categorias'));
    }

    public function store(StoreRequest $request)
    {
        Categoria::create($request->all());
        return redirect()->route('categorias.index')->with('success', 'Categoría creada con éxito.');
    }

    public function update(UpdateRequest $request, Categoria $categoria)
    {
        $category_name = $request->input('category_name');
        
        $categoria->update([
            'category_name' => $category_name,
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada con éxito.');
    }

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
