@extends('layouts.layouts')

@section('head')
<!-- Tomselect -->
<link href="{{ asset('vendor/tomselect/tom-select.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
        <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
        <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
    </ol>
</nav>
@endsection

@section('create')
@if ($errors->any())
<button id="alertButton" class="btn btn-sm btn-danger shake" data-toggle="modal" data-target="#modal-errors">
    <x-heroicon-o-question-mark-circle style="width: 20px; height: 20px;" class="text-white" />&nbsp;
    Ver errores
</button>
@endif

<a class="btn btn-sm btn-success" href="#" data-toggle="modal" data-target="#create_user">
    <i class="fa fa-plus-square"></i>&nbsp;Crear
</a>
@endsection


@section('content')
<!-- Toast messages -->
@include('layouts._toast_messages')

<div class="mb-4">
    <div class="card m-2">
        <div class="card-header bg-gray-700 text-white">
            LISTADO PRINCIPAL DE USUARIOS
        </div>
        <div class="card-body mb-2">
            <table id="users_table" class="display table table-striped" style="font-size: 0.6rem; width: 100%">
                <thead>
                    <tr class="text-center text-white" style="background-color: #4e73df;">
                        <th>Nombre</th>
                        <th>E-mail</th>
                        <th>Role actual</th>
                        <th>Teléfono</th>
                        <th style="text-align: center">Opciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                    <tr class="text-center" style="font-family: 'Nunito', sans-serif; font-size: small">
                        <td style="text-transform: uppercase">
                            <strong>
                                <a href="#" data-toggle="modal" data-target="#update_user{{ $user->id }}">{{ $user->name }}</a>
                            </strong>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <strong>{{ $user->type }}</strong>
                        </td>
                        <td>{{ $user->telephone }}</td>
                        @if($user->type == 'Administrador')
                        <td style="text-align: center">
                            <strong class="text-danger">Usuario protegido</strong>
                        </td>
                        @else
                        <td style="text-align: center">
                            @can('destroy_users')
                            <strong>No disponible</strong>
                            @else
                            <strong>&nbsp;No permitido</strong>
                            @endcan
                        </td>
                        @endif
                    </tr>

                    <!-- Update include -->
                    @include('modules.users._update')

                    @endforeach

                    <!-- Error modal include -->
                    @include('layouts._error_modals')
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create include -->
@include('modules.users._create')

@include('layouts.datatables')
<script src="{{ asset('customjs/datatables/dt_user.js') }}"></script>

<!-- ShowPass -->
<script src="{{ asset('js/custom_scripts/show_pass.js') }}"></script>

<!-- Tomselect -->
<script src="{{ asset('vendor/tomselect/tom-select.complete.js') }}"></script>
<script src="{{ asset('customjs/tomselect/ts_users.js') }}"></script>

@endsection