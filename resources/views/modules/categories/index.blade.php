@extends('layouts.layouts')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="font-size: 0.8rem">
        <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
        <li class="breadcrumb-item text-secondary"><strong>Categorías</strong></li>
        <li class="breadcrumb-item active d-none d-lg-block d-md-block" aria-current="page">Listado de categorías</li>
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

<a class="btn btn-sm btn-success" href="#" data-toggle="modal" data-target="#create_category">
    <i class="fa fa-plus-square"></i>&nbsp;Crear
</a>
@endsection

@section('content')
@include('layouts._toast_messages')
@include('modules.categories._create')
<div class="mb-4">
    <div class="card m-2">
        <div class="card-header bg-gray-700 text-white">
            LISTADO DE CATEGORÍAS
        </div>
        <div class="card-body m-2">
            <table id="categories_table" class="display table table-striped" style="width: 100%;">
                <thead>
                    <tr class="text-center text-white" style="background-color: #4e73df;">
                        <th>Nombre categoría</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $categoria)
                    <tr class="text-center" style="font-family: 'Nunito', sans-serif; font-size: small">
                        <td style="text-transform: uppercase; cursor: pointer; text-decoration: underline;"
                            data-toggle="modal"
                            data-target="#update_category{{ $categoria->id }}">
                            <span title="Editar categoría">{{ $categoria->category_name }}</span>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-danger mx-1" href="#" title="Eliminar"
                                data-toggle="modal" data-target="#delete_category{{ $categoria->id }}">
                                <i class="fa fa-trash-alt" aria-hidden="true"></i>
                            </a>
                        </td>

                        </td>
                    </tr>
                    @include('modules.categories._update')
                    @include('modules.categories._delete')

                    <!-- Error modal include -->
                    @include('layouts._error_modals')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    @include('layouts.datatables')

    <!-- Script específico para DataTable de categorías -->
    <script src="{{ asset('customjs/datatables/dt_category.js') }}"></script>
    @endsection

    <!-- Librería Emoji -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.2/dist/index.min.js"></script>