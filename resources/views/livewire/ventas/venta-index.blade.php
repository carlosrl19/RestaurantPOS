@section('head')
<!-- Venobox -->
<link href="{{ asset('vendor/venobox/venobox.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
        <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
        <li class="breadcrumb-item text-secondary"><strong>Ventas</strong></li>
        <li class="breadcrumb-item active d-none d-lg-block d-md-block">Listado principal de ventas</li>
    </ol>
</nav>
@endsection

@section('create')
<button id="abrirCierreCajaModalBtn" class="btn btn-sm btn-danger" style="font-size: clamp(0.8rem, 3vw, 0.85rem)" data-toggle="modal" data-target="#cierreCajaModal"><i class="fas fa-file-pdf"></i> Cierre de caja</button>
@endsection

<div>
    <!-- Toast messages -->
    @include('layouts._toast_messages')

    <div class="mb-4">
        <div class="card m-2">
            <div class="card-header bg-gray-700 text-white">
                REGISTRO PRINCIPAL DE VENTAS
            </div>
            <div class="card-body m-2">
                <table id="sales_table" class="display table table-striped" style="width: 100%;">
                    <thead>
                        <tr class="text-white text-center" style="background-color: #4e73df;">
                            <th>Fecha hora</th>
                            <th>Nº documento</th>
                            <th>Estado venta</th>
                            <th>Empleado</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventas as $venta)
                        <tr class="text-center" style="font-family: 'Nunito', sans-serif; font-size: small">
                            <td>{{ $venta->created_at }}</td>
                            <td>
                                <strong>
                                    {{ $venta->sale_invoice_number }}
                                </strong>
                            </td>
                            <td>
                                <div class="badge bg-success">
                                    VENTA FINALIZADA
                                </div>
                            </td>
                            <td>{{ $venta->user->name }}</td>
                            <td>
                                <a href="" data-toggle="modal" data-target="#sell_details{{ $venta->id }}" class="btn btn-sm btn-secondary">
                                    <x-heroicon-o-eye style="width: 20px; height: 20px;" class="text-white" />
                                </a>
                            </td>

                            <!-- Details include -->
                            @include('livewire.ventas._show')

                            <!-- Add voucher include -->
                            @include('livewire.ventas._add_voucher')

                            <!-- Voucher print include -->
                            @include('livewire.ventas._iframe_voucher_print')
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Cash Closing modal include -->
@include('livewire.ventas._cash_closing')

<!-- PDF Viewer includes -->
@include('livewire.ventas._iframe_cash_closing_daily')
@include('livewire.ventas._iframe_cash_closing_monthly')

<!-- Datatable include -->
@include('layouts.datatables')
<script src="{{ asset('customjs/datatables/dt_sales.js') }}"></script>

<!-- Venobox -->
<script src="{{ asset('vendor/venobox/venobox.min.js')}}"></script>
<script src="{{ asset('customjs/venobox/vb_vouchers.js')}}"></script>

<!-- PDF view -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $('#voucher_print').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var url = button.attr('href'); // Extraer la información de los atributos data-*
        var modal = $(this);
        modal.find('#pdf-frame-voucher-print').attr('src', url);
    });
    $('#voucher_print').on('hidden.bs.modal', function(e) {
        $(this).find('#pdf-frame-voucher-print').attr('src', '');
    });
</script>