@extends('layouts.layouts')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
        <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
        <li class="breadcrumb-item text-secondary"><strong>Proveedores</strong></li>
        <li class="breadcrumb-item active d-none d-lg-block d-md-block" aria-current="page">Listado principal de proveedores</li>
    </ol>
</nav>
@endsection

@can('create_provider')
@section('create')
@if ($errors->any())
<button id="alertButton" class="btn btn-sm btn-danger shake" data-toggle="modal" data-target="#modal-errors">
    <x-heroicon-o-question-mark-circle style="width: 20px; height: 20px;" class="text-white" />
    Ver errores
</button>
@endif

<a class="btn btn-sm btn-success" href="#" data-toggle="modal" data-target="#create_provider">
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
            LISTADO PRINCIPAL DE PROVEEDORES
        </div>
        <div class="card-body m-2">
            <table id="providers_table" class="display table table-striped" style="font-size: 0.6rem; width: 100%; background-color: #4e73df;">
                <thead>
                    <tr class=" text-center text-white">
                        <th>Proveedor</th>
                        <th>RTN</th>
                        <th>Teléfono empresa</th>
                        <th>Encargado</th>
                        <th>Teléfono encargado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proveedores as $item=> $proveedor)
                    <tr class="text-center" style="font-family: 'Nunito', sans-serif; font-size: small">
                        <td>
                            @can('details_provider')
                            <strong>
                                <a href="#" data-toggle="modal" data-target="#update_provider{{ $proveedor->id }}">{{ $proveedor->provider_company_name }}</a>
                            </strong>
                            @else
                            <strong>
                                <p>{{ $proveedor->provider_company_name }}</p>
                            </strong>
                            @endcan
                        </td>
                        <td>{{ $proveedor->provider_company_rtn }} </td>
                        <td>{{ $proveedor->provider_company_phone }} </td>
                        <td>{{ $proveedor->provider_contact_name }} </td>
                        <td>{{ $proveedor->provider_contact_phone }} </td>
                        <td style="width: 4rem; max-width: 4rem;">
                            @can('destroy_provider')
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_provider{{ $proveedor->id }}">
                                <i class="fa fa-trash-alt" aria-hidden="true"></i>
                            </button>
                            @else
                            <strong class="text-danger">&nbsp; No permitido</strong>
                            @endcan
                        </td>
                    </tr>

                    <!-- Update include -->
                    @include('modules.providers._update')

                    <!-- Delete include -->
                    @can('destroy_provider')
                    @include('modules.providers._delete')
                    @endcan
                    @endforeach

                    <!-- Error modal include -->
                    @include('layouts._error_modals')
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create include -->
@include('modules.providers._create')

@include('layouts.datatables')
<script src="{{ asset('customjs/datatables/dt_provider.js') }}"></script>
@endsection