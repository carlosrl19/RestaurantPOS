@extends('layouts.app')

@section('content')
<div class="card-login">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card o-hidden border-0 shadow-lg my-5" style="background-color: rgba(255, 255, 255, 0.68)">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        @php
                        $settings = App\Models\Settings::first();
                        @endphp
                        <img class="col-lg-6 d-lg-block p-4" src="{{ $settings?->system_logo_report ? Storage::url('sys_config/img/' . $settings->system_logo_report) : Storage::url('images/resources/login_logo_default.png') }}">

                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 style="text-decoration: underline;" class="h5 mb-4"><strong>{{ config('app.name') }}</strong></h1>
                                </div>
                                <div class="text-center">
                                    <h1 class="h5 text-gray-900 mb-4">Iniciar sesión</h1>
                                </div>
                                <form class="user" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <p>Correo:</p>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <p>Contraseña:</p>
                                        <div class="input-group">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                            <div class="input-group-append">
                                                <button id="show_password" class="btn btn-primary" style="display: inline-block; background: #0d6efd; color: white;" type="button" onclick="fShowPassword()">
                                                    <span class="fa fa-eye-slash icon"></span>
                                                </button>
                                            </div>
                                        </div>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block" style="display: inline-block; background: #0d6efd; color: white; border: 2px solid #ffffff;border-radius: 10px; font-size: large"> Ingresar </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-image: url('{{ $settings?->bg_login ? Storage::url('images/resources/' . $settings->bg_login) : Storage::url('images/resources/bg_login_default.webp') }}') !important;
        /* Ruta de tu imagen */
        background-size: cover;
        /* Hace que la imagen cubra todo el contenedor */
        background-repeat: no-repeat;
        /* Evita que la imagen se repita */
        background-position: center;
        backdrop-filter: blur(8px);
    }

    .card-login {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100vh;
    }
</style>

@endsection

@push('scripts')
<script src="{{ asset('js/custom_scripts/show_pass.js') }}"></script>
@endpush