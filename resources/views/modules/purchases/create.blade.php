@extends('layouts.layouts')

@section('head')
<!-- Tomselect -->
<link href="{{ asset('vendor/tomselect/tom-select.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
        <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
        <li class="breadcrumb-item active" aria-current="page">Registrar compra</li>
    </ol>
</nav>
@endsection

@section('create')
@if ($errors->any())
<button id="alertButton" class="btn btn-sm btn-danger shake" data-toggle="modal" data-target="#modal-errors">
    <x-heroicon-o-question-mark-circle style="width: 20px; height: 20px;" class="text-white" />
    Ver errores
</button>
@endif
@endsection

@section('content')
@if(session('error'))
<div class="alert alert-danger alert-dismissible" style="font-size: clamp(0.75rem, 3vw, 0.9rem);" role="alert">
    <h5 class="alert-heading">Advertencia ...</h5>
    <strong>{{ session('error') }}</strong>
    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible" style="font-size: clamp(0.75rem, 3vw, 0.9rem);" role="alert">
    <h5 class="alert-heading">Advertencia de errores ...</h5>
    <strong>Hubo errores que impidieron guardar el registro, intente nuevamente.</strong>
    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow mb-4" style="background: whitesmoke;">
    <div class="card-header py-3" style="background-color: #4e73df; border-radius:5px 5px 0 0;">
        <div style="float: left">
            <h2 class="m-0 font-weight-bold" style="color: white; font-size: clamp(0.8rem, 3vw, 1rem);">Registrar compra</h2>
        </div>
        <div style="float: right">
            <form action="{{ route('compras.destroy', $compra->id) }}" id='form_eliminar' method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" style="display: inline-block; color: white; border: 2px solid #ffffff; border-radius: 4px; font-size: clamp(0.8rem, 3vw, 0.9rem);;"
                    class="btn btn-sm btn-danger btn-user btn-block">
                    <x-heroicon-o-x-mark style="width: 20px; height: 20px;" class="text-white" />
                    {{ __('Cancelar compra') }}
                </button>
            </form>
        </div>
    </div>

    <div class="card-body" style="font-family: 'Nunito', sans-serif; font-size: clamp(0.8rem, 3vw, 0.9rem);">
        <div class="row" id="tblaBody">
            <div class="col-lg-7">
                <div class="table-responsive" id="tblaBody">
                    <table id="purchase_create_table" class="table table-striped">
                        <thead class="card-header py-3" style="background: #1a202c; color: white;">
                            <tr class="text-center">
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $sum = 0;
                            @endphp
                            @forelse($compra->detalle_compra as $detalle)
                            <tr class="text-center" style="font-size: clamp(0.7rem, 3vw, 0.85rem)" data-detalle-id="{{ $detalle->id }}">
                                <td>{{ $detalle->producto->product_name }}</td>
                                <td style="min-width: 10px; max-width: 15px">
                                    <form action="{{ route('compras.update_list') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="text" name="compra_id" value="{{ $compra->id }}" hidden>
                                        <input type="text" name="producto_id" value="{{ $detalle->producto->id }}" hidden>
                                        <input type="text" name="precio" value="{{ $detalle->precio }}" hidden>

                                        <input type="number" min="1" name="cantidad_detalle_compra" style="width: 80%; font-size: clamp(0.6rem, 3vw, 0.7rem);"
                                            value="{{ $detalle->cantidad_detalle_compra }}" class="form-control cantidad-input" id="cantidad-input_{{ $detalle->id }}">
                                        <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                            <x-heroicon-o-check-circle style="width: 20px; height: 20px;" class="text-white" />
                                            <span style="font-size: clamp(0.6rem, 3vw, 0.8rem)">Nuevos cambios realizados.</span>
                                            <button type="submit" class="btn btn-primary btn-sm" style="font-size: clamp(0.6rem, 3vw, 0.7rem); float: right;">Guardar cambios</button>
                                        </div>
                                    </form>
                                </td>
                                <td>L {{ number_format($detalle->precio, 2, ".", ",") }}</td>
                                <td>L {{ number_format($detalle->precio * $detalle->cantidad_detalle_compra, 2, ".", ",") }}</td>
                                <td style="max-width: 4rem">
                                    <form action="{{ route('compras.remove_item', $detalle->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="borrar-producto fas text-lg fa-trash-alt text-danger" style="border: none; background: none; cursor: pointer; font-size: clamp(0.7rem, 3vw, 0.9rem)"></button>
                                    </form>
                                </td>
                            </tr>
                            @php
                            $sum += $detalle->precio * $detalle->cantidad_detalle_compra;
                            @endphp
                            @empty
                            <tr>
                                <td></td>
                                <td></td>
                                <td style="text-align: center; text-decoration: underline">Sin productos en la lista de compras.</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <hr>
            </div>

            <div class="col-lg-5 d-lg-block">
                <form method="POST" class="user" action="{{route("compras.guardar_compra")}}">
                    @csrf
                    <h4 class="text-muted text-right mb-2">INFORMACIÓN/OPCIONES DE COMPRA</h4>

                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0 d-none d-sm-none d-lg-block">
                            <input type="text" name="compra_id" id="compra_id" value="{{ $compra->id }}" hidden>

                            <label for="purchase_doc">Factura:</label>
                            <input type="text" readonly class="form-control @error('purchase_doc') is-invalid @enderror" id="purchase_doc"
                                name="purchase_doc" value="CP-{{Carbon\Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-md-Hms')}}" required autocomplete="off"
                                placeholder="{{ __('') }}"
                                style="text-transform: uppercase; background-color: white; font-size: clamp(0.8rem, 3vw, 0.9rem);">
                            @error('purchase_doc')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 d-none d-sm-none d-lg-block">
                            <label for="purchase_date">Fecha:</label>
                            <input type="datetime-local" class="form-control @error('purchase_date') is-invalid @enderror"
                                id="purchase_date"
                                name="purchase_date" value="{{Carbon\Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i')}}"
                                required
                                autocomplete="off"
                                readonly
                                style="background-color: white; font-size: clamp(0.8rem, 3vw, 0.9rem);">
                            @error('purchase_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 d-none d-sm-none d-lg-block">
                            <div class="mb-3">
                                <label for="proveedor_id">Proveedor:</label>
                                <select class="form-control @error('proveedor_id') is-invalid @enderror" id="proveedor_id" required autocomplete="off" name="proveedor_id" style="font-size: clamp(0.8rem, 3vw, 0.9rem);">
                                    <option value="" disabled>Seleccione el proveedor</option>
                                    @forelse ($provedores as $provedore)
                                    <option
                                        @if( $compra->proveedor_id == $provedore->id )
                                        selected
                                        @endif value="{{ $provedore->id }}">{{ $provedore->provider_company_name }}
                                    </option>
                                    @empty
                                    <option value="0">Proveedor</option>
                                    @endforelse
                                </select>
                                @error('proveedor_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="sum">Total a pagar: </label>
                                <p style="background-color: darkgreen; color: #fff; padding: 0.5vw; border-radius: 3px;"><strong>Lps. {{ number_format($sum, 2, ".", ",") }}</strong></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row" style="margin-top: 15px">

                        <div class="col-sm-4 mb-1 mb-sm-0">
                            <a href="{{ route('compras.index') }}" style="font-size: clamp(0.8rem, 3vw, 0.9rem); display: inline-block; background: #2c3034; color: white; border: 2px solid #ffffff; border-radius: 10px;"
                                class="btn btn-google btn-sm btn-user btn-block">
                                <x-heroicon-o-arrow-left style="width: 20px; height: 20px;" class="text-white" />
                                {{ __('Regresar') }}
                            </a>
                        </div>

                        <div class="col-sm-3">
                            <a style="font-size: clamp(0.8rem, 3vw, 0.9rem); display: inline-block; background: #b02a37; color: white; border: 2px solid #ffffff; border-radius: 10px;"
                                data-toggle="modal" data-target="#modal_agregar_detalle" class="btn btn-google btn-user btn-block" onclick="provedor()">
                                <x-heroicon-o-squares-plus style="width: 20px; height: 20px;" class="text-white" />
                                Ver productos
                            </a>
                        </div>

                        @if($sum == 0)
                        <div class="col-sm-5 mb-3 mb-sm-0">
                            <button class="btn btn-sm btn-warning" type="button" disabled style="font-size: clamp(0.8rem, 3vw, 0.9rem); padding: 8px; border-radius: 10px; margin: 2px; width: 100%">
                                <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px;" class="text-gray-900" />
                                Agregar productos
                            </button>
                        </div>
                        @else
                        <div class="col-sm-5 mb-3 mb-sm-0">
                            <button type="submit" style="display: inline-block; color: white; border: 2px solid #ffffff; border-radius: 10px;"
                                class="btn btn-sm btn-primary btn-user btn-block">
                                <x-heroicon-o-check-circle style="width: 20px; height: 20px;" class="text-white" />
                                {{ __('Registrar compra') }}
                            </button>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Error modal include -->
@include('layouts._error_modals')

@include('modules.purchases._add_products')

<style>
    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
        display: block;
    }

    .table thead th {
        position: sticky;
        top: 0;
        background-color: #000;
        z-index: 1;
    }

    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        display: none;
        /* Oculto por defecto */
        transition: opacity 0.5s ease;
        opacity: 0;
    }

    .toast.show {
        display: block;
        opacity: 1;
    }

    .dt-buttons {
        display: none;
    }

    #example_filter {
        display: block;
        float: left;
    }
</style>

@include('layouts.datatables')
<script src="{{ asset('customjs/datatables/dt_purchase_create.js') }}"></script>

<!-- Get product data in product select -->
<script type="text/javascript">
    const productos = @json($productos);
</script>
<script type="text/javascript">
    const rutaImagenesProductos = "{{ asset('storage/images/products') }}";
    const rutaImagenPorDefecto = "{{ asset('storage/images/resources/no_image_available.png') }}";
</script>
<script src="{{ asset('customjs/scripts/purchase_select_creation.js') }}"></script>

<!-- Tomselect -->
<script src="{{ asset('vendor/tomselect/tom-select.complete.js') }}"></script>
<script src="{{ asset('customjs/tomselect/ts_products.js') }}"></script>


<!-- Items to purchase -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInputs = document.querySelectorAll('.cantidad-input');

        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                const detalleId = this.dataset.detalleId;
                const newQuantity = parseInt(this.value);
                const existingRow = document.querySelector(`tr[data-detalle-id="${detalleId}"]`);

                if (existingRow) {
                    const totalQuantity = newQuantity;

                    // Update the quantity and subtotal
                    existingRow.querySelector('.cantidad-input').value = totalQuantity;
                    existingRow.querySelector('td:nth-child(5)').innerText = 'L ' + (totalQuantity * parseFloat(existingRow.querySelector('input[name="product_buy_price"]').value)).toFixed(2);
                }
            });
        });
    });
</script>

<!-- Toast -->
<script>
    document.querySelectorAll('.cantidad-input').forEach(function(input) {
        input.addEventListener('input', function() {
            const toast = document.getElementById('toast');
            const detalleId = this.id.split('_')[1];

            setTimeout(function() {
                toast.classList.add('show');
                toast.querySelector('.detalle-id').textContent = detalleId;

                setTimeout(function() {
                    toast.classList.remove('show');
                }, 7000);
            }, 300);
        });
    });
</script>

@endsection