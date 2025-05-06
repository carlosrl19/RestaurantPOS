<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Settings;

use Illuminate\Http\Request;
use App\Http\Requests\Compras\StoreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Dompdf\Options;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\File;

class CompraClienteController extends Controller
{
    public function index()
    {
        $compras = Compra::get();
        $com = Compra::where('purchase_status', '=', 'p')
            ->where('user_id', '=', Auth::user()->id)
            ->get();

        return view('modules.purchases.index', compact('compras', 'com'));
    }

    public function create()
    {
        $provedores = Proveedor::all();
        $productos = Producto::select(
            'productos.id',
            'productos.product_barcode',
            'productos.product_name',
            'productos.product_stock',
            'productos.product_image',
            'productos.product_sell_price',
            'productos.product_buy_price',
        )
            ->get();

        // Obtener la compra existente o crear una nueva
        $compra = Compra::where('purchase_status', '=', 'p')
            ->where('user_id', '=', Auth::user()->id)
            ->first(); // Cambiado a first() para obtener un solo registro o null

        if (!$compra) {
            // Si no hay compra, crea una nueva
            $compra = new Compra();
            $compra->purchase_doc = '';
            $compra->purchase_date = Carbon::now();
            $compra->proveedor_id = 1; // Asegúrate de que este ID sea válido
            $compra->user_id = Auth::user()->id;
            $compra->purchase_status = 'p';
            $compra->save();
        }

        // Pasar la compra (ya sea nueva o existente) a la vista
        return view('modules.purchases.create')->with('compra', $compra)
            ->with('provedores', $provedores)
            ->with('productos', $productos);
    }

    // Agregar items a la compra (indirectamente guarda el estado de la lista porque la actualiza)
    public function store(StoreRequest $request)
    {
        // Update the supplier if provided
        if ($request->input('id_prove') != '') {
            $compra = Compra::findOrFail($request->input('compra_id'));
            $compra->proveedor_id = $request->input('id_prove');
            $compra->save();
        }

        // Check if the product already exists in the purchase details
        $detalle = DetalleCompra::where('compra_id', $request->input('compra_id'))
            ->where('producto_id', $request->input('producto_id'))
            ->first();

        if ($detalle) {
            // If it exists, update the quantity
            $detalle->cantidad_detalle_compra = $request->input('cantidad_detalle_compra');
            $detalle->save();
        } else {
            // If it doesn't exist, create a new entry
            $detalles = new DetalleCompra();
            $detalles->compra_id = $request->input('compra_id');
            $detalles->producto_id = $request->input('producto_id');
            $detalles->cantidad_detalle_compra = $request->input('cantidad_detalle_compra');
            $detalles->precio = $request->input('product_buy_price');
            $detalles->save();
        }

        return redirect()->route('compras.create');
    }

    // Actualizar desde el input del front-end
    public function newItemOrQuantity(StoreRequest $request)
    {
        // Update the supplier if provided
        if ($request->input('id_prove') != '') {
            $compra = Compra::findOrFail($request->input('compra_id'));
            $compra->proveedor_id = $request->input('id_prove');
            $compra->save();
        }

        // Check if the product already exists in the purchase details
        $detalle = DetalleCompra::where('compra_id', $request->input('compra_id'))
            ->where('producto_id', $request->input('producto_id'))
            ->first();

        if ($detalle) {
            // If it exists, update the quantity
            $detalle->cantidad_detalle_compra = $request->input('cantidad_detalle_compra');
            $detalle->save();
        } else {
            // If it doesn't exist, create a new entry
            $detalles = new DetalleCompra();
            $detalles->compra_id = $request->input('compra_id');
            $detalles->producto_id = $request->input('producto_id');
            $detalles->cantidad_detalle_compra = $request->input('cantidad_detalle_compra');
            $detalles->precio = $request->input('precio');
            $detalles->save();
        }

        return redirect()->route('compras.create');
    }

    // Finalizar compra y guardarla
    public function compra_guardar(Request $request)
    {
        $request->validate([
            'compra_id' =>  ['required'],
            'purchase_doc' => ['required', 'unique:compras,purchase_doc,' . $request->input('purchase_doc')],
            'proveedor_id' => ['required']
        ]);

        $compra = Compra::findOrFail($request->input('compra_id'));
        $compra->purchase_doc = $request->input('purchase_doc');
        $compra->purchase_date = Carbon::now();
        $compra->proveedor_id = $request->input('proveedor_id');
        $compra->user_id = Auth::user()->id;
        $compra->purchase_status = 'g';
        $compra->save();

        foreach ($compra->detalle_compra as $key => $value) {
            $prodcuto = Producto::findOrFail($value->producto_id);
            $prodcuto->product_stock = $prodcuto->product_stock + $value->cantidad_detalle_compra;
            $prodcuto->save();
        }

        return redirect()->route('compras.index')->with("success", "Registro creado exitosamente.");
    }

    // Eliminar item de la compra
    public function removeItem($id)
    {
        // Encuentra el detalle de compra por ID
        $detalle = DetalleCompra::findOrFail($id);

        // Elimina el detalle de compra
        $detalle->delete();

        // Redirige a la lista de compras con un mensaje de éxito
        return redirect()->route('compras.create')->with('success', 'Registro eliminado exitosamente.');
    }

    // Cancelar compra
    public function destroy($id)
    {
        DB::delete('delete from detalle_compras where compra_id = ?', [$id]);
        Compra::destroy($id);
        return redirect()->route('compras.index');
    }

    // Cierre de caja diario
    public function generarFacturaPorFecha(Request $request)
    {
        $fecha = $request->query('fecha');
        $compras = Compra::whereDate('purchase_date', $fecha)->get();
        $setting = Settings::first();

        // Ruta imagen logo (el reporte no muestra la imagen con Storage::url ni asset())
        $imagePath = storage_path('app/public/sys_config/img/' . $setting->system_logo_report); // Ruta al archivo
        $imageData = base64_encode(File::get($imagePath)); // Codificar la imagen a Base64
        $image_logo = 'data:image/png;base64,' . $imageData; // Crear la cadena Base64

        // Generar HTML para el PDF
        $html = view('modules.purchases.factura_cierre_diario', [
            'compras' => $compras,
            'fecha' => $fecha,
            'image_logo' => $image_logo
        ])->render();

        // Configurar opciones para Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Opcion que habilita la carga de imagenes
        $options->set('chroot', realpath(''));

        // Crear instancia de Dompdf
        $dompdf = new Dompdf($options);

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // (Opcional) Establecer tamaño de papel y orientación
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $dompdf->render();

        // Nombre del archivo con la fecha y hora actual
        $nombreArchivo = 'Compras (Cierre diario) - ' . $fecha . '.pdf';

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $nombreArchivo . '"');
    }

    // Cierre de caja mensual
    public function generarFacturaMesActual(Request $request)
    {
   
        $setting = Settings::first();

        // Ruta imagen logo (el reporte no muestra la imagen con Storage::url ni asset())
        $imagePath = storage_path('app/public/sys_config/img/' . $setting->system_logo_report); // Ruta al archivo
        $imageData = base64_encode(File::get($imagePath)); // Codificar la imagen a Base64
        $image_logo = 'data:image/png;base64,' . $imageData; // Crear la cadena Base64

        // Obtener el mes seleccionado
        $mesSeleccionado = $request->input('fechaCierreMensual');

        // Obtener el primer día del mes seleccionado
        $primerDiaMes = now()->month($mesSeleccionado)->startOfMonth()->toDateString();

        // Obtener el último día del mes seleccionado
        $ultimoDiaMes = now()->month($mesSeleccionado)->endOfMonth()->toDateString();

        // Filtrar las ventas del mes seleccionado
        $compras = Compra::whereBetween('purchase_date', [$primerDiaMes, $ultimoDiaMes])->get();

        // Generar HTML para el PDF y pasar el mes seleccionado
        $html = view('modules.purchases.factura_cierre_mensual', [
            'image_logo' => $image_logo,
            'compras' => $compras,
            'fecha' => '',
            'mesSeleccionado' => $mesSeleccionado
        ])->render();

        // Configurar opciones para Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Opcion que habilita la carga de imagenes
        $options->set('chroot', realpath(''));

        // Crear instancia de Dompdf
        $dompdf = new Dompdf($options);

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // (Opcional) Establecer tamaño de papel y orientación
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $dompdf->render();

        // Array de nombres de meses en español
        $meses = array(
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        );

        // Obtener el nombre del mes en español
        $nombreMes = $meses[$mesSeleccionado - 1];

        // Nombre del archivo con el mes en español
        $nombreArchivo = 'Compras (Cierre mensual) - ' . $nombreMes . ' ' . date('Y', strtotime($primerDiaMes)) . '.pdf';

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $nombreArchivo . '"');
    }
}
