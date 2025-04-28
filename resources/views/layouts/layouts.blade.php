<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('app.name') }}</title>
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/ico" href="{{ Storage::url('images/resources/logo.ico') }}">

    <!-- CSS Fontawesome -->
    <link href="{{ asset('admin/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <!-- Datatable -->
    <link href="{{ asset('vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <!-- CSS SB Admin -->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- CSS Bootstrap 5.2 -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Mobile menu -->
    <link href="{{ asset('css/mobile_menu.css') }}" rel="stylesheet">

    @yield('head')

    @livewireStyles
</head>

<body id="page-top">
    @livewireScripts

    <!-- Page Wrapper -->
    <div id="wrapper">

        <div id="spinner" style="position: fixed; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); z-index: 9999; display: flex; justify-content: center; align-items: center;">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            </div>
            <span id="loadingText" style="color: #fff; font-weight: bold; display: inline-block;">&nbsp; Cargando...</span>
        </div>

        <!-- Sidebar -->
        @include('layouts._sidebar')

        <!-- Mobile menu -->
        @include('layouts._mobile_menu_modal')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3 d-none d-md-block d-lg-block d-xl-block">
                        <x-heroicon-o-bars-3 style="width: 20px; height: 20px" class="text-primary" />
                    </button>

                    <!-- Toggle mobile menu -->
                    <button class="btn btn-link rounded-circle mr-3 open-menu-button d-block d-sm-block d-md-none" id="open-menu">
                        <x-heroicon-o-bars-3 style="width: 20px; height: 20px;" class="text-primary" />
                    </button>

                    @yield('sidebarToggle')

                    <div style="margin-top: auto;">
                        @yield('breadcrumb')
                    </div>

                    <ul class="navbar-nav ml-auto">
                        <div style="margin: auto;">
                            @yield('create')
                        </div>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem);">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle" style="object-fit: cover" src="{{ Storage::url('images/uploads/' . Auth::user()->image) }}" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" style="z-index: 1001;" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <x-heroicon-o-arrow-left-start-on-rectangle style="width: 20px; height: 20px;" class="text-danger" />
                                    Cerrar sesión
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div style="overflow: auto">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <x-heroicon-o-chevron-up style="width: 20px; height: 20px;" class="text-white" />
    </a>

    <!-- Logout Modal-->
    @include('auth.logout')

    <!-- Bootstrap core JavaScript-->
    <script src={{ asset("admin/jquery/jquery.min.js") }}></script>
    <script src={{ asset("admin/bootstrap/js/bootstrap.bundle.min.js") }}></script>

    <!-- Sidebar toggle script -->
    <script src={{ asset("admin/js/sb-admin-2.min.js") }}></script>

    @stack('scripts')

    <!-- Spinner -->
    <script src="{{ asset('js/custom_scripts/spinner.js') }}"></script>

    <!-- Mobile menu toggle -->
    <script src="{{ asset('customjs/scripts/mobile_menu_toggler.js') }}"></script>

    <!-- LocalStorage notification status -->
    <script src="{{ asset('customjs/scripts/toast_booking_notification.js') }}"></script>
</body>

</html>