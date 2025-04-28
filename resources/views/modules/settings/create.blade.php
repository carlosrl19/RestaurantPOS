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
<a class="btn btn-sm btn-orange mb-3" href="{{ route('settings.edit', App\Models\Settings::first()) }}">
    <x-heroicon-o-check-circle style="width: 20px; height: 20px; color: green" />
    Editar
</a>
@endif
@endsection


@section('content')
<!-- Toast messages -->
@include('layouts._toast_messages')
@include('layouts._error_modals')

<div class="mb-4">
    <div class="card m-2">
        <div class="card-header bg-gray-700 text-white">
            AJUSTES DEL SISTEMA
        </div>
        <div class="card-body mb-2">
            <form action="{{ route('settings.store')}}" method="POST" enctype="multipart/form-data" novalidate autocomplete="off">
                @csrf
                <input type="hidden" name="customer" id="customer" value="Mayorista">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <div class="row mb-3">
                                <div class="col-sm-4 mb-sm-0">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('system_name') is-invalid @enderror" id="system_name"
                                            name="system_name" value="{{ old('system_name') }}"
                                            maxlength="25"
                                            style="text-transform: uppercase;">
                                        <label for="system_name" class="form-label">Nombre sistema <span class="text-danger">*</span></label>
                                        @error('system_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-sm-0">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name"
                                            name="company_name" value="{{ old('company_name') }}"
                                            maxlength="25"
                                            style="text-transform: uppercase;">
                                        <label for="company_name" class="form-label">Nombre empresa <span class="text-danger">*</span></label>
                                        @error('company_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-sm-0">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('company_cai') is-invalid @enderror" id="company_cai"
                                            name="company_cai" value="{{ old('company_cai') }}" maxlength="32" style="text-transform: uppercase;">
                                        <label for="company_cai" class="form-label">CAI empresa <span class="text-danger">*</span></label>
                                        @error('company_cai')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4 mb-sm-0">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('company_rtn') is-invalid @enderror" id="company_rtn"
                                            name="company_rtn" value="{{ old('company_rtn') }}" maxlength="14" style="text-transform: uppercase;">
                                        <label for="company_rtn" class="form-label">R.T.N empresa <span class="text-danger">*</span></label>
                                        @error('company_rtn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-sm-0">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('company_phone') is-invalid @enderror" id="company_phone"
                                            name="company_phone" value="{{ old('company_phone') }}"
                                            maxlength="8"
                                            style="text-transform: uppercase;">
                                        <label for="company_phone" class="form-label">Teléfono empresa <span class="text-danger">*</span></label>
                                        @error('company_phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-sm-0">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('company_email') is-invalid @enderror" id="company_email"
                                            name="company_email" value="{{ old('company_email') }}" maxlength="50" style="text-transform: lowercase;">
                                        <label for="company_email" class="form-label">Email empresa <span class="text-danger">*</span></label>
                                        @error('company_email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="file" accept="image/*" class="form-control @error('system_logo') is-invalid @enderror"
                                        id="system_logo" name="system_logo" onchange="show_system_logo_create(event)">
                                    @error('system_logo')
                                    <span class="invalid-feedback" role="alert">
                                        <p><strong>{{ $message }}<a target="_blank" href="https://www.iloveimg.com/es/comprimir-imagen"> Es necesario optimizar la imagen del usuario.</strong></a></p>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="file" accept="image/*" class="form-control @error('system_logo_report') is-invalid @enderror"
                                        id="system_logo_report" name="system_logo_report" onchange="show_system_logo_reports_create(event)">
                                    @error('system_logo_report')
                                    <span class="invalid-feedback" role="alert">
                                        <p><strong>{{ $message }}<a target="_blank" href="https://www.iloveimg.com/es/comprimir-imagen"> Es necesario optimizar la imagen del usuario.</strong></a></p>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <!-- Product presentation card -->
                            <div class="col-sm-6 mb-3">
                                <div class="col-sm-12">
                                    <div class="col-lg-12 d-none d-lg-block">
                                        <div class="card">
                                            <div class="card-header text-bold text-center text-muted">
                                                Logo del sistema <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <img id="system_logo_preview_create" src="{{ Storage::url('images/resources/default_user_image.png') }}" style="object-fit: contain;" class="rounded" width="185" height="185">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Product presentation card -->
                            <div class="col-sm-6 mb-3">
                                <div class="col-sm-12">
                                    <div class="col-lg-12 d-none d-lg-block">
                                        <div class="card">
                                            <div class="card-header text-bold text-center text-muted">
                                                Logo en reportes <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <img id="system_logo_reports_preview_create" src="{{ Storage::url('images/resources/default_user_image.png') }}" style="object-fit: contain;" class="rounded" width="185" height="185">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Size error modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content border-danger-double">
                                        <div class="modal-header bg-danger-dark" style="color: white;">
                                            <p class="modal-title" id="exampleModalLabel">Advertencia</p>
                                        </div>
                                        <div class="modal-body">
                                            El tamaño máximo permitido para las imágenes de productos es 8 MB. Intente <a target="_blank" href="https://www.iloveimg.com/es/comprimir-imagen">optimizar la imagen</a>
                                            o cambiar la imagen del producto a una con menor peso.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <textarea class="form-control @error('company_short_address') is-invalid @enderror" id="company_short_address" name="company_short_address" maxlength="35"
                                            style="resize: none; height: 100px; font-size: clamp(0.7rem, 3vh, 0.8rem);">{{ old('company_short_address') }}</textarea>
                                        <label for="company_short_address" class="form-label">Dirección corta<span class="text-danger">*</span></label>
                                        @error('company_short_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <textarea class="form-control @error('company_address') is-invalid @enderror" id="company_address" name="company_address" maxlength="75"
                                            style="resize: none; height: 100px; font-size: clamp(0.7rem, 3vh, 0.8rem);">{{ old('company_address') }}</textarea>
                                        <label for="company_address" class="form-label">Dirección completa<span class="text-danger">*</span></label>
                                        @error('company_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    Registrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- User create preview -->
<script src="{{ asset('customjs/image_previews/settings_create.js') }}"></script>

@endsection