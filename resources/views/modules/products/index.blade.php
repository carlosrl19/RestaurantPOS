@extends('layouts.layouts')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="font-size: 0.8rem">
        <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
        <li class="breadcrumb-item text-secondary"><strong>Productos</strong></li>
        <li class="breadcrumb-item active d-none d-lg-block d-md-block" aria-current="page">Listado principal de productos</li>
    </ol>
</nav>
@endsection

@can('create_products')
@section('create')
@if ($errors->any())
<button id="alertButton" class="btn btn-sm btn-danger shake" data-toggle="modal" data-target="#modal-errors">
    <x-heroicon-o-question-mark-circle style="width: 20px; height: 20px;" class="text-white" />
    Ver errores
</button>
@endif

<a class="btn btn-sm btn-success" href="#" data-toggle="modal" data-target="#create_product">
    <i class="fa fa-plus-square"></i>&nbsp;Crear
</a>
@endsection
@endcan

@section('content')
<!-- Toast messages -->
@include('layouts._toast_messages')

<div class="mb-4">
    <div class="card m-2">
        <div class="card-header bg-gray-700 text-white">
            LISTADO PRINCIPAL DE PRODUCTOS
        </div>
        <div class="card-body m-2">
            <div class="col-12 mb-2" style="background-color: rgba(0, 0, 0, 0.05); padding: 10px; text-align: center">
                <div class="d-flex flex-wrap justify-content-center">
                    @foreach ($product_letters as $letter)
                    <a href="{{ route('productos.index', ['letter' => $letter]) }}" style="text-decoration: none;"
                        class="mx-1 px-2 py-1 border mb-2 {{ $selectedProductLetter == $letter ? 'bg-primary text-white' : 'bg-gray-300 text-muted' }}">
                        {{ $letter }}
                    </a>
                    @endforeach
                </div>
            </div>
            <table id="products_table" class="display table table-striped" style="width: 100%;">
                <thead>
                    <tr class="text-center text-white" style="background-color: #4e73df;">
                        <th>Producto</th>
                        <th>Código barra</th>
                        <th>Existencia</th>
                        <th>Precio compra</th>
                        <th>Precio venta</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $item => $producto)
                    <tr class="text-center" style="font-family: 'Nunito', sans-serif; font-size: small">
                        <td style="text-transform: uppercase; min-width: 150px; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <img id="imagen" class="mx-2" data-toggle="modal" data-target="#update_product{{ $producto->id }}"
                                src="{{ $producto->product_image ? Storage::url('images/products/' . $producto->product_image) : Storage::url('images/resources/no_image_available.png') }}"
                                style="object-fit: contain; border-radius: 10px; padding: 2px; border: 1px solid rgba(151, 151, 151, 0.32)"
                                class="rounded" width="32" height="32">
                            <strong>
                                <a href="#" class="text-dark" data-toggle="modal" data-target="#update_product{{ $producto->id }}">
                                    {{ $producto->product_name }}
                                </a>
                            </strong>
                        </td>
                        <td style="width: 8rem; max-width: 8rem; text-transform: uppercase">
                            @if($producto->product_barcode == '')
                            <span class="badge bg-dark text-white">SIN CODIGO</span>
                            @else
                            {{$producto->product_barcode }}
                            @endif
                        </td>
                        <td>
                            @if($producto->product_stock == 0)
                            <span class="badge bg-danger">{{ $producto->product_stock }} unidades</span>
                            @else
                            {{ $producto->product_stock }} unidades
                            @endif
                        </td>
                        <td>
                            L. {{ number_format($producto->product_buy_price, 2, ".", ",") }}
                        </td>
                        <td>
                            L. {{ number_format($producto->product_sell_price, 2, ".", ",") }}
                        </td>
                        <td style="width: 4rem; max-width: 4rem;">
                            @can('destroy_products')
                            <a class="btn btn-sm btn-danger" href="#" data-toggle="modal" data-target="#delete_product{{ $producto->id }}">
                                <i class="fa fa-trash-alt" aria-hidden="true"></i>
                            </a>
                            @else
                            <strong class="text-danger">&nbsp; No permitido</strong>
                            @endcan
                        </td>
                    </tr>
                    <!-- Update include -->
                    @include('modules.products._update')

                    <!-- Delete include -->
                    @can('destroy_products')
                    @include('modules.products._delete')
                    @endcan
                    @endforeach

                    <!-- Error modal include -->
                    @include('layouts._error_modals')
                </tbody>
            </table>
            <div class="col mt-3">
                {{ $products->links()}}
            </div>
        </div>
    </div>

    <!-- Create include -->
    @include('modules.products._create')

    <!-- Datatable -->
    @include('layouts.datatables')
    <script src="{{ asset('customjs/datatables/dt_product.js') }}"></script>

    <!-- JQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    @endsection
</div>