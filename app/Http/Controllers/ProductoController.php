<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\Products\StoreRequest;
use App\Http\Requests\Products\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        // Obtener la letra seleccionada o la letra 'A' por defecto
        $selectedProductLetter = $request->input('letter', 'A');

        $product_letters = Producto::selectRaw('UPPER(LEFT(product_name, 1)) as initial')
            ->groupBy('initial')
            ->orderBy('initial')
            ->pluck('initial');

        $products = Producto::where('product_name', 'LIKE', $selectedProductLetter . '%')
            ->orderBy('product_name')
            ->paginate(50);

        return view('modules.products.index', compact(
            'products',
            'selectedProductLetter',
            'product_letters'
        ));
    }

    public function store(StoreRequest $request)
    {
        $crearprod = new Producto();
        $crearprod->product_barcode = $request->input('product_barcode');
        $crearprod->product_name = $request->input('product_name');
        $crearprod->product_description = $request->input('product_description');
        $crearprod->product_stock = $request->input('product_stock');
        $crearprod->product_buy_price = $request->input('product_buy_price');
        $crearprod->product_sell_price = $request->input('product_sell_price');

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            // Usar el sistema de almacenamiento de Laravel
            $file_name = uniqid() . '.' . $image->getClientOriginalExtension();
            // Guardar la imagen en el disco 'public'
            $path = $image->storeAs('images/products', $file_name, 'public');

            // Optimizar la imagen recién subida con spatie/image-optimizer
            $optimizerChain = OptimizerChainFactory::create();
            // Asegúrate de usar la ruta completa al archivo
            $optimizerChain->optimize(storage_path('app/public/' . $path));

            // Asignar el nombre del archivo a la propiedad del producto
            $crearprod['product_image'] = $file_name;
        } else {
            $crearprod['product_image'] = 'no_image_available.png';
        }

        // Guardar el producto en la base de datos
        $crearprod->save();

        return redirect()->route('productos.index')->with('success', 'Registro creado exitosamente.');
    }

    public function update(UpdateRequest $request, $id)
    {
        $producto = Producto::findOrFail($id);

        // Actualizar los valores del producto
        $producto->product_barcode = $request->input('product_barcode');
        $producto->product_name = $request->input('product_name');
        $producto->product_description = $request->input('product_description');
        $producto->product_stock = $request->input('product_stock');
        $producto->product_buy_price = $request->input('product_buy_price');
        $producto->product_sell_price = $request->input('product_sell_price');

        // Manejar la imagen del producto si se proporciona
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $file_name = uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images/products', $file_name, 'public');

            // Eliminar la imagen anterior si existe y no es la imagen por defecto
            if ($producto->product_image != 'no_image_available.png') {
                $oldImagePath = storage_path('app/public/images/products/' . $producto->product_image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            // Optimizar la imagen recién subida
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize(storage_path('app/public/' . $path));

            $producto->product_image = $file_name;
        }

        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Registro actualizado exitosamente.');
    }


    public function destroy($id)
    {
        try {
            Producto::destroy($id);

            return redirect()->route('productos.index')->with('success', 'Registro eliminado exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->route('productos.index')->with('error', 'El producto no puede ser eliminado porque existen compras asociadas.');
            }
            return redirect()->route('productos.index')->with('error', 'Acción no permitida.');
        }
    }
}
