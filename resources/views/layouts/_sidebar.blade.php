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

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProductos"
        aria-expanded="false" aria-controls="collapseProductos">
        <x-heroicon-o-square-3-stack-3d class="text-white" style="width: 20px; height: 20px;" />&nbsp;
        <span class="text-white">Productos</span>
    </a>
    <div id="collapseProductos" class="collapse" aria-labelledby="headingProductos" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('productos.index') }}">Lista de productos</a>
        <a class="collapse-item" href="{{ route('categorias.index') }}">Lista de categorias</a>
        </div>
    </div>
</li>


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            <x-heroicon-o-shopping-bag class="text-white" style="width: 20px; height: 20px" />&nbsp;
            <span class="text-white">Compras</span>
        </a>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('sidebar_provider')
                <a class="collapse-item" href="{{route('proveedor.index')}}">Proveedores</a>
                @endcan
                @can('sidebar_purchase')
                <a class="collapse-item" href="{{route('compras.index')}}">Registro de compras</a>
                @endcan
            </div>
        </div>
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