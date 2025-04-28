@extends('layouts.layouts')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
        <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
        <li class="breadcrumb-item text-secondary"><strong>Compras</strong></li>
        <li class="breadcrumb-item active d-none d-md-block d-lg-block" aria-current="page">Listado principal de compras</li>
    </ol>
</nav>
@endsection

@can('create_purchase')
@section('create')

<button id="abrirCierreCajaModalBtn" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#cierreCajaModal"><i class="fas fa-file-pdf"></i> Cierre de caja</button>

<a class="btn btn-sm btn-success" href="{{ route('compras.create', $com->count() > 0 ? $com[0]->id : null) }}">
    <i class="fa fa-plus-square"></i>
    @if($com->count() == 0)
    Crear
    @else
    Continuar compra
    @endif
</a>

@endsection
@endcan

@section('content')
<!-- Toast messages -->
@include('layouts._toast_messages')

<div class="mb-4">
    <div class="card m-2">
        <div class="card-header bg-gray-700 text-white">
            REGISTRO PRINCIPAL DE COMPRAS
        </div>
        <div class="card-body m-2">
            <table id="purchases_table" class="display table table-striped" style="width: 100%;">
                <thead>
                    <tr class="text-center text-white" style="background-color: #4e73df;">
                        <th>Fecha hora</th>
                        <th>Nº documento</th>
                        <th>Estado compra</th>
                        <th>Empleado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compras as $compra)
                    <!-- Show details include -->
                    @include('modules.purchases._show')

                    <tr class="text-center" style="font-family: 'Nunito', sans-serif; font-size: small">
                        <td>
                            {{ $compra->purchase_date }}
                        </td>
                        <td>
                            @can('details_purchase')
                            <a href="#" data-toggle="modal" data-target="#buy_details{{ $compra->id }}">{{ $compra->purchase_doc }}</a>
                            @else
                            {{ $compra->purchase_doc }}
                            @endcan
                        </td>

                        @if($compra->purchase_status == 'p')
                        <td>
                            <span class="badge bg-danger">COMPRA EN PROCESO</span>
                        </td>
                        @elseif($compra->purchase_status == 'g')
                        <td>
                            <span class="badge bg-success">COMPRA FINALIZADA</span>
                        </td>
                        @endif

                        <td>
                            {{ $compra->user->name }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Cierre de caja -->
@include('modules.purchases._cash_closing')

<!-- PDF Viewer includes -->
@include('modules.purchases._iframe_cash_closing_daily')
@include('modules.purchases._iframe_cash_closing_monthly')

@include('layouts.datatables')
<script src="{{ asset('customjs/datatables/dt_purchase.js') }}"></script>

@endsection