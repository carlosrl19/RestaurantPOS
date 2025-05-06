<!-- Contenedor del menú -->
<div id="mobile-menu" class="mobile-menu">
    <div class="menu-content">
        <button id="close-menu" class="close-menu-button">&times;</button>
        <div>
            @can('dashboard')
            <!-- Heading -->
            <div class="sidebar-heading text-gray-700">
                MODULO DASHBOARD
            </div>

            <!-- Nav Item - Ventas -->
            <p class="nav-item">
                <a class="nav-link fw-bold text-white" href="/">
                    <x-heroicon-o-home class="text-white" style="width: 20px; height: 20px;" />&nbsp;
                    <span>DASHBOARD</span>
                </a>
            </p>
            @endcan

            <!-- Divider -->
            <hr class="text-white">

            @can('sidebar_products')
            <!-- Heading -->
            <div class="sidebar-heading text-gray-700">
                MODULO DE PRODUCTOS
            </div>

            <!-- Nav Item - Productos -->
            <p class="nav-item">
                <a class="nav-link fw-bold text-white" href="{{route('productos.index')}}">
                    <x-heroicon-o-square-3-stack-3d class="text-white" style="width: 20px; height: 20px;" />&nbsp;
                    <span>PRODUCTOS</span>
                </a>
            </p>
            @endcan

            <!-- Divider -->
            <hr class="text-white">

            <!-- Heading -->
            <div class="sidebar-heading text-gray-700">
                MODULO DE COMPRAS
            </div>

            @can('sidebar_provider')
            <p class="nav-item">
                <a class="nav-link fw-bold text-white" href="{{route('proveedor.index')}}">
                    <x-heroicon-o-user-group class="text-white" style="width: 20px; height: 20px;" />&nbsp;
                    <span>PROVEEDORES</span>
                </a>
            </p>
            @endcan
            @can('sidebar_provider')
            <p class="nav-item">
                <a class="nav-link fw-bold text-white" href="{{route('compras.index')}}">
                    <x-heroicon-o-shopping-bag class="text-white" style="width: 20px; height: 20px;" />&nbsp;
                    <span>REGISTRO DE COMPRAS</span>
                </a>
            </p>
            @endcan

            <!-- Divider -->
            <hr class="text-white">

            <!-- Heading -->
            <div class="sidebar-heading text-gray-700">
                MODULO DE VENTAS
            </div>

            @can('sidebar_sales')
            <!-- Nav Item - Ventas -->
            <p class="nav-item">
                <a class="nav-link fw-bold text-white" href="{{ route('ventas.index') }}">
                    <x-heroicon-o-presentation-chart-line class="text-white" style="width: 20px; height: 20px" />&nbsp;
                    <span>REGISTRO DE VENTAS</span></a>
            </p>
            @endcan

            <p class="nav-item">
                <a class="nav-link fw-bold text-white" href="{{ route('ventas.create') }}">
                    <x-heroicon-o-tv class="text-white" style="width: 20px; height: 20px" />&nbsp;
                    <span class="text-white">FACTURAR</span>
                </a>
            </p>

            <!-- Divider -->
            <hr class="text-white">

            @can('sidebar_users')
            <div class="sidebar-heading text-gray-700">
                MODULO USUARIOS
            </div>

            <p class="nav-item">
                <a class="nav-link fw-bold text-white" href="{{route('usuarios.index')}}">
                    <x-heroicon-o-user-group class="text-white" style="width: 20px; height: 20px" />&nbsp;
                    <span>USUARIOS</span>
                </a>
            </p>
            @endcan                   
        </div>
    </div>
</div>