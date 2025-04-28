<!-- Modal -->
<div class="modal fade" id="sell_details{{ $venta->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white fw-bold">
                <p class="modal-title" id="exampleModalLabel">Detalles venta</p>
            </div>
            <div class="modal-body">
                <div class="row" style="font-size: 0.86rem">
                    <!-- Encabezado -->
                    @if($venta->tipo_pago != 'EFECTIVO')
                    <div class="col-8">
                        <div class="header-modal">
                            @php
                            $settings = App\Models\Settings::first();
                            @endphp
                            <div class="logo_factura">
                                <img width="128" height="128"
                                    src="{{ $settings?->system_logo_report 
                                    ? Storage::url('sys_config/img/' . $settings->system_logo_report) 
                                    : Storage::url('images/resources/login_logo_default.png') }}">
                            </div>
                            <div class="info_empresa d-none d-sm-none d-md-block d-lg-block">
                                <h2 style="font-size: clamp(1rem, 3vw, 1.2rem); text-transform: uppercase"><strong>{{ config('app.name') }}</strong></h2>
                                <p>
                                    <small>
                                        {{ $settings->company_address ?? 'N/A' }}
                                    </small>
                                </p>
                            </div>
                            <div class="info_factura col-lg-6 col-md-6 col-sm-12">
                                <h4>Documento venta / <span class="text-muted">{{ $venta->id }}</span></h4>
                                <p class="m-1"><strong>No. Doc.:</strong> {{$venta->sale_invoice_number}}</p>
                                <p class="m-1"><strong>Fecha:</strong> {{\Carbon\Carbon::parse($venta->sale_invoice_date)->isoFormat("DD")}} de {{\Carbon\Carbon::parse($venta->sale_invoice_date)->isoFormat("MMMM")}}, {{\Carbon\Carbon::parse($venta->sale_invoice_date)->isoFormat("YYYY")}}</p>
                                <p class="m-1 text-muted"><small><strong>Empleado:</strong> {{ $venta->user->name}}</small></p>
                            </div>
                        </div>

                        <!-- Lista de productos (Simulación de tabla) -->
                        <div class="productos-lista" style="margin-top: 20px; overflow: auto; max-height: 30rem">
                            <!-- Encabezados -->
                            <div class="productos-header row-tabla" style="position: sticky; top: 0; background-color:rgb(231, 231, 231); z-index: 1;">
                                <span class="text-uppercase">Producto</span>
                                <span class="text-uppercase">Cantidad</span>
                                <span class="text-uppercase">Precio</span>
                                <span class="text-uppercase">Subtotal</span>
                            </div>

                            <!-- Productos -->
                            @php
                            $total = 0;
                            $counter = 0; // Inicializamos el contador
                            @endphp

                            @foreach ($venta->detalle_venta as $detalle)
                            @php
                            $counter++; // Incrementamos el contador en cada iteración
                            @endphp
                            <div class="producto-item row-tabla">
                                <span>{{ $detalle->producto->product_name }}</span>
                                <span>{{ $detalle->cantidad_detalle_venta }}</span>
                                <span>L. {{ number_format($detalle->precio_venta, 2, ".", ",") }}</span>
                                <span>L. {{ number_format($detalle->precio_venta * $detalle->cantidad_detalle_venta, 2, ".", ",") }}</span>
                            </div>
                            @php
                            $total += $detalle->precio_venta * $detalle->cantidad_detalle_venta;
                            @endphp
                            @endforeach
                        </div>

                        <!-- Total -->
                        <div>
                            <div class="total mt-2" style="font-weight: bold; text-align: center; background-color:rgb(21, 167, 69); color: white; border-radius: 3px">
                                <div class="row m-2">
                                    <div class="col-lg-12">
                                        SU VENTA TOTAL FUE DE:
                                        <h4>L. {{ number_format($total, 2, ".", ",") }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($counter > 8)
                        <div class="mensaje-adicional text-muted">
                            <strong>Nota:</strong> Deslize la lista hacia abajo para ver todos los productos.
                        </div>
                        @endif
                    </div>
                    <div class="col-4">
                        <h5 class="text-muted text-center">COMPROBANTE PAGO</h5>
                        <img style="display: grid; margin: auto; border: 1px solid #e3e3e3; border-radius: 5px; max-height: 260px;" src="{{ $venta->voucher_pago ? Storage::url('images/vouchers/' . $venta->voucher_pago) : Storage::url('images/resources/receipt.png')}}" alt="">
                    </div>
                    @else
                    <!-- Venta no fue mediante Transferencia/Depósito -->
                    <div class="col-12">
                        <div class="header-modal">
                            @php
                            $settings = App\Models\Settings::first();
                            @endphp

                            <div class="logo_factura">
                                <img width="128" height="128"
                                    src="{{ $settings?->system_logo_report 
                                    ? Storage::url('sys_config/img/' . $settings->system_logo_report) 
                                    : Storage::url('images/resources/login_logo_default.png') }}">
                            </div>
                            <div class="info_empresa d-none d-sm-none d-md-block d-lg-block">
                                <h2 style="font-size: clamp(1rem, 3vw, 1.2rem); text-transform: uppercase"><strong>{{ config('app.name') }}</strong></h2>
                                <p>
                                    <small>
                                        {{ $settings->company_address ?? 'N/A' }}
                                    </small>
                                </p>
                            </div>
                            <div class="info_factura col-lg-6 col-md-6 col-sm-12">
                                <h4>Documento venta / <span class="text-muted">{{ $venta->id }}</span></h4>
                                <p class="m-1"><strong>No. Doc.:</strong> {{$venta->sale_invoice_number}}</p>
                                <p class="m-1"><strong>Fecha:</strong> {{\Carbon\Carbon::parse($venta->sale_invoice_date)->isoFormat("DD")}} de {{\Carbon\Carbon::parse($venta->sale_invoice_date)->isoFormat("MMMM")}}, {{\Carbon\Carbon::parse($venta->sale_invoice_date)->isoFormat("YYYY")}}</p>
                                <p class="m-1 text-muted"><small><strong>Empleado:</strong> {{ $venta->user->name}}</small></p>
                            </div>
                        </div>

                        <!-- Lista de productos (Simulación de tabla) -->
                        <div class="productos-lista" style="margin-top: 20px; overflow: auto; max-height: 30rem">
                            <!-- Encabezados -->
                            <div class="productos-header row-tabla" style="position: sticky; top: 0; background-color:rgb(231, 231, 231); z-index: 1;">
                                <span class="text-uppercase">Producto</span>
                                <span class="text-uppercase">Cantidad</span>
                                <span class="text-uppercase">Precio</span>
                                <span class="text-uppercase">Subtotal</span>
                            </div>

                            <!-- Productos -->
                            @php
                            $total = 0;
                            $counter = 0; // Inicializamos el contador
                            @endphp

                            @foreach ($venta->detalle_venta as $detalle)
                            @php
                            $counter++; // Incrementamos el contador en cada iteración
                            @endphp
                            <div class="producto-item row-tabla">
                                <span>{{ $detalle->producto->product_name }}</span>
                                <span>{{ $detalle->cantidad_detalle_venta }}</span>
                                <span>L. {{ number_format($detalle->precio_venta, 2, ".", ",") }}</span>
                                <span>L. {{ number_format($detalle->precio_venta * $detalle->cantidad_detalle_venta, 2, ".", ",") }}</span>
                            </div>
                            @php
                            $total += $detalle->precio_venta * $detalle->cantidad_detalle_venta;
                            @endphp
                            @endforeach
                        </div>

                        <!-- Total -->
                        <div>
                            <div class="total mt-2" style="font-weight: bold; text-align: center; background-color:rgb(21, 167, 69); color: white; border-radius: 3px">
                                <div class="row m-2">
                                    <div class="col-lg-12">
                                        SU VENTA TOTAL FUE DE:
                                        <h4>L. {{ number_format($total, 2, ".", ",") }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($counter > 8)
                        <div class="mensaje-adicional text-muted">
                            <strong>Nota:</strong> Deslize la lista hacia abajo para ver todos los productos.
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-sm btn-dark" data-dismiss="modal">Regresar</a>
                <a href="{{ route('ventas.voucher_print', $venta->id) }}" data-toggle="modal" data-target="#voucher_print" class="btn btn-sm btn-secondary">
                    <x-heroicon-o-printer style="width: 20px; height: 20px;" class="text-white" />&nbsp;
                    <span>
                        Imprimir
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>

<link href={{ asset("css/facturas.css") }} rel="stylesheet" type="text/css">