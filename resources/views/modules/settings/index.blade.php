@extends('layouts.layouts')

@section('head')

@endsection

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
        <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
        <li class="breadcrumb-item active" aria-current="page">Configuración</li>
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

@if(App\Models\Settings::count() == 0)
<a href="{{ route('settings.create') }}" class="btn btn-sm btn-success">
    <i class="fa fa-plus-square"></i>&nbsp;Crear
</a>
@else
<a class="btn btn-sm btn-primary mb-3" href="{{ route('settings.edit', App\Models\Settings::first()) }}">
    <x-heroicon-o-pencil-square style="width: 20px; height: 20px; color: white" />
    Editar
</a>
@endif
@endsection


@section('content')
<!-- Toast messages -->
@include('layouts._toast_messages')

<div class="mb-4">
    <div class="card m-2">
        <div class="card-header bg-gray-700 text-white">
            AJUSTES DEL SISTEMA
        </div>
        <div class="card-body mb-2">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <!-- System name / Company name -->
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" readonly class="form-control" value="{{ $settings->system_name ?? 'N/A' }}">
                                <label for="system_name" class="form-label">Nombre del sistema</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" readonly class="form-control" value="{{ $settings->company_name ?? 'N/A' }}">
                                <label for="system_name" class="form-label">Nombre de la empresa</label>
                            </div>
                        </div>
                    </div>

                    <!-- CAI / RTN company -->
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" readonly class="form-control" value="{{ $settings->company_cai ?? 'N/A' }}">
                                <label for="company_cai" class="form-label">CAI empresa</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" readonly class="form-control" value="{{ $settings->company_rtn ?? 'N/A' }}">
                                <label for="company_rtn" class="form-label">RTN empresa</label>
                            </div>
                        </div>
                    </div>

                    <!-- Phone / email company -->
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" readonly class="form-control" value="{{ $settings->company_phone ?? 'N/A' }}">
                                <label for="company_phone" class="form-label">CAI empresa</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" readonly class="form-control" value="{{ $settings->company_email ?? 'N/A' }}">
                                <label for="company_email" class="form-label">RTN empresa</label>
                            </div>
                        </div>
                    </div>

                    <!-- Company address -->
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <textarea class="form-control" readonly id="company_short_address" name="company_short_address" style="resize: none; height: 100px; font-size: clamp(0.7rem, 3vh, 0.8rem);">{{ $settings->company_short_address ?? 'N/A' }}</textarea>
                                <label for="company_short_address" class="form-label">Dirección corta</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <textarea class="form-control" readonly id="company_address" name="company_address" style="resize: none; height: 100px; font-size: clamp(0.7rem, 3vh, 0.8rem);">{{ $settings->company_address ?? 'N/A' }}</textarea>
                                <label for="company_address" class="form-label">Dirección completa</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="row text-center">
                        <div class="col">
                            <img class="mb-3" style="border: 1px solid #eee; padding: 5px; border-radius: 5px" id="logoPreviewOld" width="120" height="120" src="{{ Storage::url('sys_config/img/' . ($settings->system_logo_report ?? 'default_image.png')) }}">
                            <p>Logo reportes</p>
                        </div>
                        <div class="col">
                            <img class="mb-3" style="border: 1px solid #eee; padding: 5px; border-radius: 5px" id="systemIconPreviewOld" width="120" height="120" src="{{ Storage::url('sys_config/img/' . ($settings->system_logo ?? 'default_image.png')) }}"><br>
                            <p>Logo sistema</p>
                        </div>
                        <div class="col">
                            <img class="mb-3" style="border: 1px solid #eee; padding: 5px; border-radius: 5px" id="systemBgLoginOld" width="200" height="120" src="{{ Storage::url('images/resources/' . ($settings->bg_login ?? 'bg_login.png')) }}"><br>
                            <p>Background login</p>
                        </div>
                        <div class="col">
                            <img class="mb-3" style="border: 1px solid #eee; padding: 5px; border-radius: 5px" id="systemIconPreviewOld" width="120" height="120" src="{{ Storage::url('images/resources/' . ($settings->system_favicon ?? 'favicon.ico')) }}"><br>
                            <p>
                            <x-heroicon-o-star style="width: 20px; height: 20px;" class="text-warning"/>
                                Favicon
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection