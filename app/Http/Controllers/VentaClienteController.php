<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Settings;
use App\Models\Venta;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Dompdf\Dompdf;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class VentaClienteController extends Controller
{
    // Cierre de caja diario
    public function generarFacturaPorFecha(Request $request)
    {
        $fecha = $request->query('fecha');
        $setting = Settings::first();
        $ventas = Venta::whereDate('sale_invoice_date', $fecha)->get();

        // Ruta imagen logo (el reporte no muestra la imagen con Storage::url ni asset())
        $imagePath = storage_path('app/public/sys_config/img/' . $setting->system_logo_report); // Ruta al archivo
        $imageData = base64_encode(File::get($imagePath)); // Codificar la imagen a Base64
        $image_logo = 'data:image/png;base64,' . $imageData; // Crear la cadena Base64

        // Generar HTML para el PDF
        $html = view('livewire.ventas.factura_cierre_diario', [
            'ventas' => $ventas,
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
        $nombreArchivo = 'Ventas (Cierre diario) - ' . $fecha . '.pdf';

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

        // Filtrar las ventas del mes actual
        $ventas = Venta::whereBetween('sale_invoice_date', [$primerDiaMes, $ultimoDiaMes])->get();

        // Generar HTML para el PDF
        $html = view('livewire.ventas.factura_cierre_mensual', [
            'ventas' => $ventas,
            'fecha' => '',
            'mesSeleccionado' => $mesSeleccionado,
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

        // Establecer el idioma local a español
        setlocale(LC_TIME, 'es_ES');

        // Nombre del archivo con la fecha y hora actual en español
        $nombreArchivo = 'Ventas (Cierre mensual) - ' . $nombreMes . ' ' . date('Y', strtotime($primerDiaMes)) . '.pdf';

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $nombreArchivo . '"');
    }

    // Voucher image upload
    public function voucher(Request $request, $id)
    {
        $venta = Venta::findOrFail($id);

        // Manejar la imagen del voucher de pago si se proporciona
        if ($request->hasFile('voucher_pago')) {
            $image = $request->file('voucher_pago');
            // Generar un nombre de archivo único
            $file_name = uniqid() . '.' . $image->getClientOriginalExtension();
            // Guardar la imagen en el disco 'public'
            $path = $image->storeAs('images/vouchers', $file_name, 'public');

            // Eliminar la imagen anterior si existe y no es la imagen por defecto
            if ($venta->voucher_pago != 'receipt.png' && $venta->voucher_pago != null) {
                $oldImagePath = storage_path('app/public/images/vouchers/' . $venta->voucher_pago);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            // Optimizar la imagen recién subida
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize(storage_path('app/public/' . $path));

            // Asignar el nuevo nombre de archivo a la propiedad del voucher
            $venta->voucher_pago = $file_name;
        }

        // Guardar los cambios en la venta
        $venta->save();

        return redirect()->route("ventas.index")->with("success", "Registro actualizado exitosamente.");
    }

    // Voucher print
    public function voucher_print($id)
    {
        $venta = Venta::findOrFail($id);
        $setting = Settings::first();
        $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');

        // Ruta imagen logo (el reporte no muestra la imagen con Storage::url ni asset())
        $imagePath = storage_path('app/public/sys_config/img/' . $setting->system_logo_report); // Ruta al archivo
        $imageData = base64_encode(File::get($imagePath)); // Codificar la imagen a Base64
        $image_logo = 'data:image/png;base64,' . $imageData; // Crear la cadena Base64

        // Configurar el locale en Carbon
        Carbon::setLocale('es');

        // Obtener la fecha actual en español
        $fecha = Carbon::now()->setTimezone('America/Costa_Rica');
        $dia = $fecha->format('d');
        $mes = $fecha->translatedFormat('F'); // 'F' para nombre completo del mes
        $anio = $fecha->format('Y');

        // Configuración de opciones para Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Opcion que habilita la carga de imagenes
        $options->set('chroot', realpath(''));

        // Crear instancia de Dompdf con las opciones configuradas
        $pdf = new Dompdf($options);

        // Cargar el contenido de la vista en Dompdf
        $pdf->loadHtml(view('livewire.ventas.factura_voucher', compact(
            'venta',
            'todayDate',
            'image_logo',
            'dia',
            'mes',
            'anio'
        )));

        // Establecer el tamaño y la orientación del papel
        $pdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $pdf->render();
        $fileName = 'FACTURA-' . $venta->sale_invoice_number . '.pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"')
            ->header('Access-Control-Allow-Origin', '*') // Permite el acceso desde iframe
            ->header('X-Frame-Options', 'ALLOW-FROM *'); // Permite embebido en iframe
    }
}
