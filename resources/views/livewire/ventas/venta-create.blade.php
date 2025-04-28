<div>
    @section('head')
    <link rel="stylesheet" href="{{ asset('css/pos.css')}}">
    @endsection

    @section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
            <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
            <li class="breadcrumb-item active " aria-current="page">Facturación</li>
        </ol>
    </nav>
    @endsection

    <!-- Toast messages -->
    @include('layouts._toast_messages')

    <!-- Toast product removed messages -->
    <div id="toast-container-removed" aria-live="polite" aria-atomic="true" style="position: fixed; bottom: 20px; right: 20px; z-index: 1050;">
        <div class="toast" id="product_removed_toast" role="alert" aria-live="assertive" aria-atomic="true" data-animation="true" data-autohide="true" data-delay="4800">
            <div class="toast-header text-white bg-warning">
                <strong class="me-auto"><i class="fas fa-bell"></i>&nbsp;Notificación</strong>
                <button type="button" class="btn-close" data-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Producto eliminado del carrito.
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <form>
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="card" style="min-height: 83vh; max-height: 83vh; overflow: auto;">
                        <div class="card-body">
                            <div style="max-height: 65vh; overflow-y: auto;">
                                <table class="table table-striped table-bordered border-b-2">
                                    <!-- Encabezado de la tabla -->
                                    <thead class="bg-secondary text-white" style="font-size: clamp(0.8rem, 3vw, 0.9rem);">
                                        <tr>
                                            <th style="min-width: 9.5vw;">PRODUCTO</th>
                                            <th style="width: 3vw;">CANTIDAD</th>
                                            <th>PRECIO</th>
                                            <th>SUBTOTAL</th>
                                            <th style="max-width: 4rem"></th>
                                        </tr>
                                    </thead>
                                    <!-- Cuerpo de la tabla -->
                                    <tbody style="font-size: clamp(0.8rem, 3vw, 0.9rem);">
                                        @php
                                        $total_carrito = 0;
                                        @endphp
                                        @forelse ($carrito as $index => $item )
                                        <tr>
                                            <td class="titulo">
                                                <div style="width: 100%; white-space: wrap;">
                                                    {{$item["detalle"]}}
                                                </div>
                                            </td>
                                            <td>
                                                <input style="width: 80%;" type="number" min="1" value="{{$item["cantidad_detalle_venta"]}}" wire:change="actualizar_total($event.target.value, {{ $index}})" class="input_Element">
                                            </td>
                                            <td>L.{{number_format($item["precio_venta"], 2, ".", ",")}}</td>
                                            <td>L.{{number_format($item["total"], 2, ".", ",")}}</td>
                                            <td style="max-width: 4rem; text-align: center">
                                                <a class="borrar-producto fas text-lg fa-trash-alt text-danger" wire:click.prevent="eliminar_item_carrito({{$index}})"></a>
                                            </td>
                                        </tr>
                                        @php
                                        $total_carrito += $item["total"];
                                        @endphp
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer border-0">
                            <br>
                            <p class="text-muted" style="text-align: center; display: flex; justify-content: space-between; font-size: 18px; font-weight: bold">Total:
                                <span style="margin-left: auto;">Lps.
                                    <span id="totalAmount" style="margin-left: auto;">{{number_format( $total_carrito, 2, ".", ",") }}</span>
                            </p>
                            <input type="text" name="pagado" hidden>

                            @if($total_carrito == 0)
                            <button class="btn btn-warning" type="button" disabled style="font-size: clamp(0.5rem, 3vw, 1rem); border: none; margin: 5px; width: 100%">
                                <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px;" class="text-gray-900" />&nbsp;
                                <span style="font-size: clamp(0.9rem, 3vw, 1.1rem)">
                                    Agregar productos
                                </span>
                            </button>
                            @else
                            <div style="display: flex; align-items: center;">
                                <select class="form-select tom-select" name="tipo_pago" id="tipo_pago" wire:model="data.tipo_pago" style="margin-right: 10px;">
                                    <option value="" selected disabled>Seleccione el tipo de pago para poder finalizar la venta</option>
                                    <option value="EFECTIVO">EFECTIVO</option>
                                    <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                                    <option value="TARJETA">TARJETA</option>
                                </select>

                                @if($data['tipo_pago'])
                                <a wire:click.prevent="guardar(true)"
                                    class="btn btn-primary"
                                    id="Submit"
                                    style="font-size: clamp(0.5rem, 3vw, 1rem); border: none; margin: 5px; width: 100%"
                                    wire:loading.attr="disabled"
                                    onclick="disableButton(this)">
                                    <x-heroicon-o-check-circle style="width: 20px; height: 20px;" class="text-white" />&nbsp;
                                    <span style="font-size: clamp(0.9rem, 3vw, 1.1rem)">
                                        Finalizar venta
                                    </span>
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
        </form>

        <!-- Divider -->
        <div class="bg-white d-xs-block d-sm-block d-md-none d-lg-none d-xl-none" style="margin-top: 2rem"></div>

        <!-- Products images div -->
        <div class="col-lg-6">
            <div class="card" style="display: flex; min-height: 83vh; max-height: 83vh; overflow: auto">
                <div class="card-header card-header-fixed">
                    <div class="mb-1" style="display: flex;">
                        <button class="btn btn-sm btn-danger" style="margin-right: 5px;" type="button" disabled><i class="fas fa-search"></i></button>
                        <input type="text" autocomplete="off" oninput="this.value = this.value.toUpperCase()" name="buscar_producto" id="buscar_producto" wire:model.debounce.500ms="filtro_producto" class="form-control border-1 small" placeholder="Buscar producto..." autocomplete="off" aria-label="Search" aria-describedby="basic-addon2">
                    </div>
                    <div class="d-flex mb-2 p-2 justify-content-center" style="background-color: rgba(0,0,0,0.05);">
                        {{ $productos->links() }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" style="overflow: auto;">
                        <section>
                            <div class="producto" id="producto" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));">
                                @if(count($productos) > 0)
                                @foreach($productos as $pro)
                                <div class="agregar-factura" x-data="{ open: true }" style="display: block; height: 170px; width: auto; padding: 3px">
                                    <div class="card h-100 btn" data-id="{{$pro->id}}" data-codigo="{{$pro->product_barcode}}" wire:click="agregar_item_carrito({{$pro}})" style="background-color: {{ $pro->product_stock == 0 ? '#ff5a5a' : 'inherit' }}; opacity: {{ $pro->product_stock == 0 ? '0.5' : '1' }}">
                                        <!-- Cantidad en product_stock -->
                                        @php
                                        $index = array_search("{$pro->id}", array_column($carrito, 'producto_id'));
                                        @endphp
                                        <div class="badge bg-dark position-absolute" style="top: 0.5rem; right: 0.5rem">
                                            @if(isset($carrito[$index]) && $carrito[$index]["producto_id"] == $pro->id)
                                            {{$pro->product_stock - $carrito[$index]["cantidad_detalle_venta"] }} unidades
                                            @else
                                            {{$pro->product_stock}} unidades
                                            @endif
                                        </div>

                                        <!-- Imagen del producto-->
                                        <img class="card-img-top" style="object-fit: contain" src="{{ $pro->product_image ? Storage::url('images/products/' . $pro->product_image) : Storage::url('images/resources/no_image_available.png') }}" width="60px" height="80px" title="{{$pro->product_name}} {{$pro->modelo}}" loading="lazy" />

                                        <div style="text-align: center;">
                                            <div class="text-center">

                                                <!-- Nombre del producto -->
                                                <p class="nombre {{ $pro->product_stock == 0 ? 'text-white' : '' }}" id="nombre" style="width: 120px; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                                                    <strong style="font-size: 0.7rem" class="text-secondary {{ $pro->product_stock == 0 ? 'text-white' : '' }}">{{$pro->product_name}}</strong>
                                                </p>

                                                <!-- Precio del producto-->
                                                <div class="p">
                                                    <span id="pre" class="pre {{ $pro->product_stock == 0 ? 'text-white' : 'text-muted' }} text-decoration-line">
                                                        <strong style="font-size: 15px"> L.{{number_format($pro->product_sell_price, 2, ".", ",")}}</strong>
                                                        @if(isset($carrito[$index]) && $carrito[$index]["producto_id"] == $pro->id)
                                                        @php
                                                        $carrito[$index]["precio_venta"] = $pro->product_sell_price;
                                                        $carrito[$index]["total"] = $carrito[$index]["precio_venta"] * $carrito[$index]["cantidad_detalle_venta"];
                                                        @endphp
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <!-- Mensaje de búsqueda sin resultados -->
                                <div class="alert alert-danger" role="alert">
                                    <x-heroicon-o-circle-stack style="width: 20px; height: 20px;" class="text-danger" />&nbsp; <span style="font-size: clamp(0.7rem, 6vw, 0.8rem)">Sin productos que coincidan con la búsqueda.</span>
                                </div>
                                @endif
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputBuscarProducto = document.getElementById('buscar_producto');

        inputBuscarProducto.addEventListener('input', function() {
            const codigo = inputBuscarProducto.value.trim(); // Obtiene el código del input
            if (codigo) {
                const botonProducto = document.querySelector(`[data-codigo="${codigo}"]`); // Encuentra el botón con ese código
                if (botonProducto) { // Si existe un botón para ese código
                    botonProducto.click(); // Simula un clic en el botón
                    inputBuscarProducto.value = '';

                    // Simular Ctrl+Z 
                    // Se simula para que el input se limpie y pueda escanearse otro producto sin necesidad de limpiar manualmente
                    document.execCommand('undo', false, null);
                }
            }
        });
    });
</script>

<!-- Toast when user delete a product from sell list -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Livewire.on('productoEliminado', () => {
            var toastEl = document.getElementById('product_removed_toast');
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
    });
</script>

<!-- Disable save sell button when is clicked -->
<script>
    function disableButton(button) {
        button.disabled = true;
        button.classList.add('disabled'); // Add a 'disabled' class for visual styling (optional)
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...'; // Change the button text and add a spinner
    }
</script>
</div>