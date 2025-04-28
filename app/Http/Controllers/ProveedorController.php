<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Http\Requests\Providers\StoreRequest;
use App\Http\Requests\Providers\UpdateRequest;

use Illuminate\Http\Request;

class ProveedorController extends Controller
{

    public function index(Request $request)
    {
        $proveedores = Proveedor::get();
        return view('modules.providers.index', compact('proveedores'));
    }

    public function store(StoreRequest $request)
    {
        Proveedor::create($request->all());
        return redirect()->route('proveedor.index')->with('success', 'Registro creado exitosamente.');
    }

    public function update(UpdateRequest $request, Proveedor $proveedor)
    {
        $proveedor->update($request->all());
        return redirect()->route("proveedor.index")->with("success", "Registro actualizado exitosamente.");
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::find($id);

        if ($proveedor->compra()->exists()) {
            return redirect()->route('proveedor.index')->with("error", "No se puede eliminar el proveedor porque tiene compras asociadas.");
        }

        Proveedor::destroy($id);
        return redirect()->route('proveedor.index')->with("success", "Registro eliminado exitosamente.");
    }
}
