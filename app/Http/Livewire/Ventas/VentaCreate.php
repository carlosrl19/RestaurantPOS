<?php

namespace App\Http\Livewire\Ventas;

use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination; // Importa WithPagination

class VentaCreate extends Component
{
    use WithPagination;

    public $filtro_producto = "";
    public $venta;
    public $editar = false;

    public $data = [
        "sale_invoice_number" => "Nuevo",
        "sale_invoice_date" => "",
        "user_id" => "",
        "username" => "",
        "cliente_id" => "1",
        "cliente_telefono" => "",
        "sale_invoice_client_type" => "",
        "estado",
        "tipo_pago" => "",
    ];

    public $carrito = [];

    protected $rules = [
        'data.cliente_id' => 'required',
        'data.sale_invoice_client_type' => 'required',
        'carrito' => 'required',
    ];

    protected $messages = [
        'data.cliente_id.required' => '¡Debes seleccionar un cliente antes de realizar la venta!',
        'data.sale_invoice_client_type.required' => '¡Debes seleccionar el tipo de cliente!',
    ];

    public function render()
    {
        $this->data["sale_invoice_client_type"] = "consumidor_final";

        return view('livewire.ventas.venta-create', [
            "productos" => Producto::where("product_name", "like", "%{$this->filtro_producto}%")
                ->orWhere("product_barcode", "like", "%{$this->filtro_producto}%")
                ->paginate(18)
        ])
            ->extends('layouts.layouts')
            ->section('content');
    }

    public function mount($id = null)
    {
        if ($id != null) {
            $this->editar = true;
            $this->venta = Venta::findOrFail($id);

            $this->data["sale_invoice_number"] = $this->venta->sale_invoice_number;
            $this->data["sale_invoice_date"] = $this->venta->sale_invoice_date;
            $this->data["user_id"] = $this->venta->user_id;
            $this->data["username"] = $this->venta->user->name;
            $this->data["cliente_id"] = $this->venta->cliente_id;
            $this->data["cliente_telefono"] = $this->venta->cliente->telephone;
            $this->data["sale_invoice_client_type"] = $this->venta->sale_invoice_client_type;
            $this->data["estado"] = $this->venta->estado;
            $this->data["tipo_pago"] = $this->venta->tipo_pago;

            $productos = Producto::whereIn('id', $this->venta->detalle_venta->pluck('producto_id'))->get();
            foreach ($this->venta->detalle_venta as $item) {
                $producto = $productos->firstWhere('id', $item->producto_id);
                // Accede a los datos del producto sin realizar una consulta dentro del bucle
            }
        } else {
            $this->data["sale_invoice_date"] = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d') . 'T' . Carbon::now()->setTimezone('America/Costa_Rica')->format('H:i');
            $this->data["user_id"] = Auth::user()->id;
            $this->data["username"] = Auth::user()->name;
        }
    }

    // propiedad computada para traer el tipo de cliente seleccionado
    public function getCustomerProperty()
    {
        if ($this->data["cliente_id"]) {
            return User::find($this->data["cliente_id"])->customer;
        }
    }

    // propiedad computada para calcular el total de la venta
    public function getTotalProperty()
    {
        $totales = array_column($this->carrito, 'total');
        return array_sum($totales);
    }

    public static function generar_numero_factura()
    {
        $ultima_venta = Venta::select('sale_invoice_number')->where('estado', 'pagado')->orderByDesc('id')->first();

        if (!$ultima_venta) {
            return '001-001-00-00000001';
        } else {
            $numero = (int) substr($ultima_venta->sale_invoice_number, -8) + 1;
            return '001-001-00-' . str_pad($numero, 8, '0', STR_PAD_LEFT);
        }
    }

    public function actualizar_total($cantidad, $index = 0)
    {
        // actualizo la cantidad y el total
        $stock = Producto::findOrFail($this->carrito[$index]["producto_id"])->product_stock;

        if ($cantidad >= $stock) {
            $this->carrito[$index]["cantidad_detalle_venta"] = $stock;
        } else {
            $this->carrito[$index]["cantidad_detalle_venta"] = $cantidad;
        }
        $this->carrito[$index]["total"] = $this->carrito[$index]["cantidad_detalle_venta"] * $this->carrito[$index]["precio_venta"];
    }

public function agregar_item_carrito($producto)
{
    $item = [
        "id" => $producto["id"], // ← Añadir ID para usar en wire:key
        "producto_id" => $producto["id"], // se puede mantener esto si se va usar para otro lado
        "detalle" => "{$producto["product_name"]}",
        "product_image" => $producto["product_image"], // ← Añadir imagen
        "cantidad_detalle_venta" => 1,
        "precio_venta" => $producto["product_sell_price"],
        "total" => $producto["product_sell_price"],
    ];

        // verifico si el producto que se va a agregar ya existe
        $existe = in_array("{$producto['id']}", array_column($this->carrito, 'producto_id'));

        // si el producto no existe entonces lo agrego de lo contrario muestro un error
        if (!$existe) {

            $stock = Producto::findOrFail($producto["id"])->product_stock;
            if ($stock == 0) {
            } else {
                array_push($this->carrito, $item);
            }
        } else {
            #busco el index del elemento que contengo el id del producto que ando buscando
            $index = array_search("{$producto['id']}", array_column($this->carrito, 'producto_id'));

            // aumento la cantidad en 1 y el total
            $this->carrito[$index]["cantidad_detalle_venta"] += 1;
            $stock = Producto::findOrFail($producto["id"])->product_stock;
            if ($this->carrito[$index]["cantidad_detalle_venta"] > $stock) {
                $this->carrito[$index]["cantidad_detalle_venta"] = $stock;
            }

            $this->carrito[$index]["total"] = $this->carrito[$index]["cantidad_detalle_venta"] * $this->carrito[$index]["precio_venta"];
        }
    }

    public function guardar($pagar = false)
    {
        // valido los datos del formulario
        $this->validate();

        if (!$this->editar) {
            $venta = new Venta();
            $venta->sale_invoice_number = $pagar == true ? $this->generar_numero_factura() : $this->data["sale_invoice_number"];
            $venta->sale_invoice_date = $this->data["sale_invoice_date"];
            $venta->user_id = $this->data["user_id"];
            $venta->cliente_id = $this->data["cliente_id"];
            $venta->sale_invoice_client_type = $this->data["sale_invoice_client_type"];
            $venta->total = $this->total;
            $venta->tipo_pago = $this->data['tipo_pago'];
            $venta->estado = ($pagar == true ? "pagado" : "en_proceso");
            $venta->save();

            if ($venta) {
                $total_detalles = 0;
                foreach ($this->carrito as $key => $item) {
                    $detalle_venta = new DetalleVenta();
                    $detalle_venta->venta_id = $venta->id;
                    $detalle_venta->producto_id = $item["producto_id"];
                    $detalle_venta->cantidad_detalle_venta = $item["cantidad_detalle_venta"];
                    if ($this->data["sale_invoice_client_type"] == 'consumidor_final') {
                        $detalle_venta->precio_venta = Producto::findOrFail($item["producto_id"])->product_sell_price;
                    }
                    $detalle_venta->save();
                    $total_detalles += $detalle_venta->cantidad_detalle_venta * $detalle_venta->precio_venta;
                }
                foreach ($venta->detalle_venta as $key => $value) {
                    $prodcuto = Producto::findOrFail($value->producto_id);
                    $prodcuto->product_stock = $prodcuto->product_stock - $value->cantidad_detalle_venta;
                    $prodcuto->save();
                }

                $venta->tipo_pago = $this->data['tipo_pago'];
                $venta->total = $this->total;
                $venta->save();
            }

            return redirect()->route('ventas.create')->with('success', 'La venta fue registrada exitosamente.');
        } else {
            $this->venta->sale_invoice_number = $pagar == true ? $this->generar_numero_factura() : $this->data["sale_invoice_number"];
            $this->venta->sale_invoice_date = $this->data["sale_invoice_date"];
            $this->venta->user_id = $this->data["user_id"];
            $this->venta->cliente_id = $this->data["cliente_id"];
            $this->venta->sale_invoice_client_type = $this->data["sale_invoice_client_type"];
            $this->venta->total = $this->total;
            $this->venta->estado = $pagar == true ? "pagado" : "en_proceso";
            $this->venta->tipo_pago = $this->tipo_pago;
            $this->venta->save();

            //elimino los items de esta venta para volver agregarlos con los nuevos cambios
            DetalleVenta::where('venta_id', $this->venta->id)->truncate();

            foreach ($this->carrito as $key => $item) {
                $detalle_venta = new DetalleVenta();
                $detalle_venta->venta_id = $this->venta->id;
                $detalle_venta->producto_id = $item["producto_id"];
                $detalle_venta->cantidad_detalle_venta = $item["cantidad_detalle_venta"];
                $detalle_venta->precio_venta = $item["precio_venta"];
                $detalle_venta->save();
            }

            return redirect()->route('ventas.index')->with('success', '¡Venta editada con éxito!');
        }
    }

    public function eliminar_item_carrito($index)
    {
        // elimino el item del arreglo
        unset($this->carrito[$index]);

        // Emitir un evento para notificar al frontend
        $this->emit('productoEliminado');
    }

    // Reinicia la paginación al cambiar el filtro de productos
    // Esto en Livewire siempre es igual, es decir, updated[nombrePropiedad], se le conoce como lifecycle hooks
    public function updatedFiltroProducto()
    {
        $this->resetPage(); 
    }
}
