<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion d-none d-sm-none d-md-block d-lg-block" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        @php
        $settings = App\Models\Settings::first();
        @endphp

        <img class="rounded-circle bg-white p-1 me-2 navbar-brand" height="45"
            src="{{ $settings?->system_logo_report 
            ? Storage::url('sys_config/img/' . $settings->system_logo) 
            : Storage::url('images/resources/login_logo_default.png') }}">

        <div class="sidebar-brand-text mx-3">
            {{ $settings && $settings->system_name != '' ? $settings->system_name:config('app.name') }}
        </div>
    </a>

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ $settings->system_version }}
    </div>

    @can('dashboard')
    <!-- Divider -->
    <hr class="sidebar-divider bg-white" style="margin-top: 1rem">

    <!-- Heading -->
    <div class="sidebar-heading">
        Dashboard
    </div>

    <!-- Nav Item - Ventas -->
    <li class="nav-item">
        <a class="nav-link text-white" href="/">
            <x-heroicon-o-home class="text-white" style="width: 20px; height: 20px;" />&nbsp;
            <span>Dashboard</span>
        </a>
    </li>
    @endcan

    <!-- Divider -->
    <hr class="sidebar-divider bg-white" style="margin-top: 1rem">

    <!-- Heading -->
    <div class="sidebar-heading">
        Productos / Servicios
    </div>

    <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('categorias.index') }}">
            <x-heroicon-o-cube class="text-white" style="width: 20px; height: 20px" />&nbsp;
            <span>Categorias</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('productos.index') }}">
            <x-heroicon-o-square-3-stack-3d class="text-white" style="width: 20px; height: 20px" />&nbsp;
            <span>Productos</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider bg-white" style="margin-top: 1rem">

    <!-- Heading -->
    <div class="sidebar-heading">
        Compras
    </div>

    <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('proveedor.index') }}">
            <x-heroicon-o-user-group class="text-white" style="width: 20px; height: 20px" />&nbsp;
            <span>Proveedores</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('compras.index') }}">
            <x-heroicon-o-shopping-cart class="text-white" style="width: 20px; height: 20px" />&nbsp;
            <span>Registro de compras</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider bg-white" style="margin-top: 1rem">

    <!-- Heading -->
    <div class="sidebar-heading">
        MODULO DE VENTAS
    </div>

    @can('sidebar_sales')
    <!-- Nav Item - Ventas -->
    <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('ventas.index') }}">
            <x-heroicon-o-presentation-chart-line class="text-white" style="width: 20px; height: 20px" />&nbsp;
            <span>Registro de ventas</span></a>
    </li>
    @endcan

    <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('ventas.create') }}">
            <x-heroicon-o-tv class="text-white" style="width: 20px; height: 20px" />&nbsp;
            <span>Facturar</span>
        </a>
    </li>

    @can('sidebar_users')
    <hr class="sidebar-divider bg-white" style="margin-top: 1rem">

    <div class="sidebar-heading">
        MODULO ADMIN
    </div>

    <li class="nav-item">
        <a class="nav-link text-white" href="{{route('usuarios.index')}}">
            <x-heroicon-o-user-group class="text-white" style="width: 20px; height: 20px" />&nbsp;
            <span>Usuarios</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-white" href="{{route('settings.index')}}">
            <x-heroicon-o-cog-8-tooth class="text-white" style="width: 20px; height: 20px" />&nbsp;
            <span>Configuración</span>
        </a>
    </li>
    @endcan
</ul>