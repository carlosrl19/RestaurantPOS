<?php

namespace App\Http\Controllers;

use App\Http\VarStatic;
use App\Models\DetalleCompra;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ingresos = 0;
        $egresos = 0;

        $productosMasVendidos = DB::table('detalle_ventas as d')
            ->join('productos as p', 'd.producto_id', '=', 'p.id')
            ->join('ventas as v', 'd.venta_id', '=', 'v.id')
            ->select(
                'p.id',
                'p.product_name',
                DB::raw('SUM(d.cantidad_detalle_venta) as total_vendido'),
                DB::raw('(SELECT MAX(v2.sale_invoice_date) FROM detalle_ventas d2 JOIN ventas v2 ON d2.venta_id = v2.id WHERE d2.producto_id = p.id) as ultima_venta')
            )
            ->where('v.sale_invoice_date', '>=', now()->subDays(30))
            ->groupBy('p.id', 'p.product_name') // Incluir todas las columnas no agregadas
            ->orderBy('total_vendido', 'DESC')
            ->limit(10)
            ->get();

        $productosNoVendidos = DB::table('productos as p')
            ->leftJoin('detalle_ventas as d', 'p.id', '=', 'd.producto_id')
            ->leftJoin('ventas as v', function ($join) {
                $join->on('d.venta_id', '=', 'v.id')
                    ->where('v.sale_invoice_date', '>=', now()->subDays(30));
            })
            ->select(
                'p.id',
                'p.product_name',
                DB::raw('(SELECT MAX(v2.sale_invoice_date) FROM detalle_ventas d2 JOIN ventas v2 ON d2.venta_id = v2.id WHERE d2.producto_id = p.id) as ultima_venta'),
                DB::raw('(SELECT SUM(d3.cantidad_detalle_venta) FROM detalle_ventas d3 JOIN ventas v3 ON d3.venta_id = v3.id WHERE d3.producto_id = p.id AND v3.sale_invoice_date >= NOW() - INTERVAL 30 DAY) as total_vendido')
            )
            ->whereNull('v.id') // Filtrar productos que no han sido vendidos en los últimos 30 días
            ->get();


        // Obtener la fecha de inicio de la semana actual
        $fecha_inicio_semana = Carbon::now()->startOfWeek();

        // Obtener la fecha de fin de la semana actual
        $fecha_fin_semana = Carbon::now()->endOfWeek();

        // Obtener la fecha actual
        $fecha_actual = Carbon::now()->format('Y-m-d');

        $datos_ventas = DB::select('CALL traer_ventas_por_mes(?)', [Carbon::now()->format('Y')]);
        $datos_compras = DB::select('CALL traer_compras_por_mes(?)', [Carbon::now()->format('Y')]);
        $vendedores = DB::select('CALL traer_vendedores(?,?)', [Carbon::now()->format('Y'), Carbon::now()->format('m')]);

        // Nueva consulta para obtener los totales de ventas de cada vendedor para la semana actual
        $ventas_semana_actual = Venta::whereBetween('sale_invoice_date', [$fecha_inicio_semana, $fecha_fin_semana])
            ->select('user_id', DB::raw('SUM(total) as total_semana_actual'))
            ->groupBy('user_id')
            ->get();

        // Consulta para obtener las ventas del día actual
        $ventas_dia = Venta::whereDate('sale_invoice_date', $fecha_actual)
            ->select('user_id', DB::raw('SUM(total) as total_dia'))
            ->groupBy('user_id')
            ->get();

        $valores_ventas = [];
        foreach ($datos_ventas as $key => $value) {
            $valores_ventas[] = $value;
        }

        $valores_compre = [];
        foreach ($datos_compras as $key => $value) {
            $valores_compre[] = $value;
        }

        foreach (DetalleVenta::all() as $valor) {
            $ingresos += $valor->cantidad_detalle_venta * $valor->precio_venta;
        }

        foreach (DetalleCompra::all() as $valor) {
            $egresos += $valor->cantidad_detalle_compra * $valor->precio;
        }

        if (Auth::user()->hasRole('Developer') || Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Empleado')) {
            return view('home')->with('ingresos', $ingresos)
                ->with('egresos', $egresos)
                ->with('productosMasVendidos', $productosMasVendidos)
                ->with('productosNoVendidos', $productosNoVendidos)
                ->with('valores_ventas', $valores_ventas)
                ->with('valores_compre', $valores_compre)
                ->with('vendedores', $vendedores)
                ->with('ventas_semana_actual', $ventas_semana_actual)
                ->with('ventas_dia', $ventas_dia);
        }

        $use = User::findOrFail(Auth::user()->id);
        $use->assignRole('Cliente');
        Auth::login($use);
    }
}
