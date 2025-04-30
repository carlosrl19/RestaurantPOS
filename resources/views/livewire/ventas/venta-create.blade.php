<div>
    @section('head')
    <link rel="stylesheet" href="{{ asset('css/pos.css') }}">
    @endsection

    @section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
            <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
            <li class="breadcrumb-item active" aria-current="page">Facturación</li>
        </ol>
    </nav>
    @endsection

    @include('layouts._toast_messages')

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
                <!-- PRIMERO: Catálogo de productos -->
                <div class="col-lg-6">
                    <div class="card" style="display: flex; min-height: 83vh; max-height: 83vh; overflow: auto">
                        <div class="card-header card-header-fixed">
                            <div class="mb-1" style="display: flex;">
                                <button class="btn btn-sm btn-danger" style="margin-right: 5px;" type="button" disabled><i class="fas fa-search"></i></button>
                                <input type="text" autocomplete="off" oninput="this.value = this.value.toUpperCase()" name="buscar_producto" id="buscar_producto" wire:model.debounce.500ms="filtro_producto" class="form-control border-1 small" placeholder="Buscar producto..." autocomplete="off" aria-label="Search" aria-describedby="basic-addon2">
                            </div>
                            <div class="mb-2 d-flex flex-wrap gap-2">
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-th-large"></i> All
                                </button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-coffee"></i> Desayuno
                                </button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-utensils"></i> Almuerzo
                                </button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-drumstick-bite"></i> Cena
                                </button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-ice-cream"></i> Postre
                                </button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-glass-cheers"></i> Bebidas gaseosas
                                </button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-wine-glass-alt"></i> Bebidas alcohólicas
                                </button>
                            </div>
                            <div class="d-flex mb-2 p-2 justify-content-center" style="background-color: rgba(0,0,0,0.05);">
                                {{ $productos->links() }}
                            </div>

                            <div class="card-body">
                                <div class="row" style="overflow: auto;">
                                    <section class="w-100">
                                        <div class="producto" id="producto" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                                            @if(count($productos) > 0)
                                                @foreach($productos as $pro)
                                                    <div class="agregar-factura" style="width: 100%; height: 220px; padding: 0; margin: 0;">
                                                        <div class="card h-100 position-relative" style="background-color: {{ $pro->product_stock == 0 ? '#ff5a5a' : 'inherit' }}; opacity: {{ $pro->product_stock == 0 ? '0.5' : '1' }}; overflow: hidden;">
                                                            <div class="btn w-100 h-100 d-flex flex-column align-items-center justify-content-start position-relative"
                                                                data-id="{{ $pro->id }}" data-codigo="{{ $pro->product_barcode }}"
                                                                wire:click="agregar_item_carrito({{ $pro }})"
                                                                style="padding: 4px;">
                                                                <img class="card-img-top"
                                                                    style="object-fit: cover; height: 130px; width: 120px;"
                                                                    src="{{ $pro->product_image ? asset('storage/images/products/' . $pro->product_image) : asset('storage/images/resources/no_image_available.png') }}"
                                                                    title="{{ $pro->product_name }} {{ $pro->modelo }}" loading="lazy" />
                                                                <div class="position-absolute bottom-0 start-0 m-1 text-start">
                                                                    <p class="nombre mb-0 {{ $pro->product_stock == 0 ? 'text-white' : 'text-secondary' }}"
                                                                        style="width: 130px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 0.75rem;">
                                                                        <strong>{{ $pro->product_name }}</strong>
                                                                    </p>
                                                                    <span class="{{ $pro->product_stock == 0 ? 'text-white' : 'text-muted' }}">
                                                                        <strong style="font-size: 10px;">L.{{ number_format($pro->product_sell_price, 2, '.', ',') }}</strong>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- Controles +/- -->
                                                            <div class="position-absolute" style="bottom: 0.2rem; right: 0.2rem;" x-data="{ qty: 1 }">
                                                                <div class="d-flex align-items-center bg-light px-1 py-0 rounded shadow-sm" style="height: 28px;">
                                                                    <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-1"
                                                                        style="font-size: 0.75rem; line-height: 1rem;"
                                                                        @click="qty > 1 ? qty-- : qty = 1">-</button>
                                                                    <input type="number" min="1" :max="{{ $pro->product_stock }}"
                                                                        x-model="qty"
                                                                        class="form-control form-control-sm text-center mx-1"
                                                                        style="width: 35px; height: 24px; padding: 2px; font-size: 0.75rem;" />
                                                                    <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-1"
                                                                        style="font-size: 0.75rem; line-height: 1rem;"
                                                                        @click="qty < {{ $pro->product_stock }} ? qty++ : qty = {{ $pro->product_stock }}">+</button>
                                                                </div>
                                                                <span x-effect="$wire.agregar_item_carrito({{ $pro->id }}, qty)"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="alert alert-danger" role="alert">
                                                    <x-heroicon-o-circle-stack style="width: 20px; height: 20px;" class="text-danger" />
                                                    &nbsp;
                                                    <span style="font-size: clamp(0.7rem, 6vw, 0.8rem)">Sin productos que coincidan con la búsqueda.</span>
                                                </div>
                                            @endif
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEGUNDO: Carrito de productos -->
                <div class="col-lg-6">
                    <div class="card" style="min-height: 83vh; max-height: 83vh; overflow: auto;">
                        <div class="card-body">
                            <div style="max-height: 65vh; overflow-y: auto;">
                                @php $total_carrito = 0; @endphp
                                <table class="table table-striped table-bordered border-b-2">
                                    <thead class="bg-secondary text-white" style="font-size: clamp(0.8rem, 3vw, 0.9rem); position: sticky; top: 0; z-index: 10;">
                                        <tr>
                                            <th style="min-width: 9.5vw;">PRODUCTO</th>
                                            <th class="text-center" style="width: 3vw;">CANTIDAD</th>
                                            <th style="max-width: 4rem"></th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: clamp(0.8rem, 3vw, 0.9rem);">
                                        @forelse ($carrito as $index => $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                    <div wire:key="product-{{ $item['id'] }}">
                                                        <img class="card-img-top"
                                                            style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;" 
                                                            src="{{ $item['product_image'] ? asset('storage/images/products/' . $item['product_image']) : asset('storage/images/resources/no_image_available.png') }}"
                                                            title="{{ $item['detalle'] }}"
                                                            loading="lazy" />
                                                    </div>

                                                    <div>
                                                        <div class="fw-bold" style="font-size: 0.9rem;">{{ $item["detalle"] }}</div>
                                                        <div class="text-muted" style="font-size: 0.8rem;">L.{{ number_format($item["precio_venta"], 2, ".", ",") }}</div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary d-none"
                                                        wire:click="actualizar_total({{ $item['cantidad_detalle_venta'] - 1 }}, {{ $index }})"
                                                        @if($item['cantidad_detalle_venta'] <= 1) disabled @endif>-</button>

                                                    <input type="number" min="1" value="{{ $item['cantidad_detalle_venta'] }}"
                                                        wire:change="actualizar_total($event.target.value, {{ $index }})"
                                                        class="form-control form-control-sm mx-1 text-center" style="width: 50px;" />

                                                    <button type="button" class="btn btn-sm btn-outline-secondary d-none"
                                                        wire:click="actualizar_total({{ $item['cantidad_detalle_venta'] + 1 }}, {{ $index }})">+</button>
                                                </div>

                                            </td>

                                            <td>
                                            <a class="text-danger" style="cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                                wire:click.prevent="eliminar_item_carrito({{ $index }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            </td>
                                        </tr>
                                        @php $total_carrito += $item["total"]; @endphp
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No hay productos en el carrito.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer border-0">
                        <br>
                        <p class="text-muted d-flex justify-content-between fw-bold fs-5">
                            Total:
                            <span id="totalAmount">Lps. {{ number_format($total_carrito, 2, ".", ",") }}</span>
                        </p>
                        <input type="text" name="pagado" hidden>

                        @if($total_carrito == 0)
                            <button class="btn btn-warning" type="button" disabled style="font-size: clamp(0.5rem, 3vw, 1rem); border: none; margin: 5px; width: 100%">
                                <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px;" class="text-gray-900" />&nbsp;
                                <span style="font-size: clamp(0.9rem, 3vw, 1.1rem)">Agregar productos</span>
                            </button>
                        @else
                            <div class="d-flex align-items-center">
                                <select class="form-select tom-select" name="tipo_pago" id="tipo_pago" wire:model="data.tipo_pago" style="margin-right: 10px;">
                                    <option value="" selected disabled>Seleccione el tipo de pago</option>
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
                                        <span style="font-size: clamp(0.9rem, 3vw, 1.1rem)">Finalizar venta</span>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputBuscarProducto = document.getElementById('buscar_producto');
            inputBuscarProducto.addEventListener('input', function() {
                const codigo = inputBuscarProducto.value.trim();
                if (codigo) {
                    const botonProducto = document.querySelector(`[data-codigo="${codigo}"]`);
                    if (botonProducto) {
                        botonProducto.click();
                        inputBuscarProducto.value = '';
                        document.execCommand('undo', false, null);
                    }
                }
            });
        });

        Livewire.on('productoEliminado', () => {
            var toastEl = document.getElementById('product_removed_toast');
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });

        function disableButton(button) {
            button.disabled = true;
            button.classList.add('disabled');
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        }
    </script>
</div>
