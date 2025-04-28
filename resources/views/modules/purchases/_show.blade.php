<!-- Modal -->
<div class="modal fade" id="buy_details{{ $compra->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white fw-bold">
                <p class="modal-title" id="exampleModalLabel">Detalles compra</p>
            </div>
            <div class="modal-body">
                <div class="row" style="font-size: 0.86rem">
                    <!-- Encabezado -->
                    <div class="header-modal">
                        @php
                        $settings = App\Models\Settings::first();
                        @endphp

                        <div class="logo_factura">
                            <img src="{{ Storage::url('sys_config/img/' . ($settings->system_logo_report ?? 'default_image.png')) }}" alt="" width="128" height="128" />
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
                            <h5>Documento compra / <span class="text-muted">{{ $compra->id }}</span></h5>
                            <p class="m-1"><strong>No. Doc.:</strong> {{$compra->purchase_doc}}</p>
                            <p class="m-1"><strong>Fecha:</strong> {{\Carbon\Carbon::parse($compra->purchase_date)->isoFormat("DD")}} de {{\Carbon\Carbon::parse($compra->purchase_date)->isoFormat("MMMM")}}, {{\Carbon\Carbon::parse($compra->purchase_date)->isoFormat("YYYY")}}</p>
                            <p class="m-1 text-muted"><small><strong>Empleado:</strong> {{ $compra->user->name}}</smal>
                            </p>
                        </div>
                    </div>

                    <!-- Lista de productos (Simulación de tabla) -->
                    <div class="productos-lista" style="margin-top: 20px; overflow: auto; max-height: 30rem;">
                        <!-- Encabezados -->
                        <div class="productos-header row-tabla" style="position: sticky; top: 0; background-color:rgb(231, 231, 231); z-index: 1;">
                            <span class="text-uppercase">PRODUCTO</span>
                            <span class="text-uppercase">CANT.</span>
                            <span class="text-uppercase">PRECIO</span>
                            <span class="text-uppercase">SUBTOTAL</span>
                        </div>

                        <!-- Productos -->
                        @php
                        $total = 0;
                        $counter = 0;
                        @endphp

                        @foreach ($compra->detalle_compra as $detalle)
                        @php
                        $counter++; // Incrementamos el contador en cada iteración
                        @endphp
                        <div class="producto-item row-tabla">
                            <span>{{ $detalle->producto->product_name }}</span>
                            <span>{{ $detalle->cantidad_detalle_compra }}</span>
                            <span>L. {{ number_format($detalle->precio, 2) }}</span>
                            <span>L. {{ number_format($detalle->precio * $detalle->cantidad_detalle_compra, 2) }}</span>
                        </div>
                        @php
                        $total += $detalle->precio * $detalle->cantidad_detalle_compra;
                        @endphp
                        @endforeach
                    </div>

                    <!-- Total -->
                    <div class="total mt-2" style="font-weight: bold; text-align: center; background-color:rgb(255, 53, 53); color: white; border-radius: 3px">
                        <div class="row m-2">
                            <div class="col-lg-12">
                                SU COMPRA TOTAL FUE DE:
                                <h4>L. {{ number_format($total, 2, ".", ",") }}</h4>
                            </div>
                        </div>
                    </div>

                    @if ($counter > 8)
                    <div class="mensaje-adicional text-muted">
                        <strong>Nota:</strong> Deslize la lista hacia abajo para ver todos los productos.
                    </div>
                    @endif
                </div>
            </div>

            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-sm btn-dark">{{ __('Regresar') }}</a>
            </div>
        </div>
    </div>
</div>

<link href={{ asset("css/facturas.css") }} rel="stylesheet" type="text/css">