<!-- Modal -->
<div class="modal fade" id="voucher_pago{{ $venta->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white fw-bold">
                <p class="modal-title" id="exampleModalLabel">Agregar voucher de pago</p>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('ventas.voucher', ['venta' => $venta->id]) }}" enctype="multipart/form-data" novalidate autocomplete="off">
                    @method('PUT')
                    @csrf
                    <div class="m-2">
                        <div class="row g-3">
                            <!-- Product presentation card -->
                            <div class="col-sm-12">
                                <div class="col-sm-12">
                                    <div class="col-lg-12 d-none d-lg-block">
                                        <div class="card">
                                            <div class="card-header text-bold text-center text-muted">
                                                Comprobante de pago
                                            </div>
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <img id="voucher_image_preview_{{ $venta->id }}" src="{{ Storage::url('images/resources/receipt.png') }}" style="object-fit: contain;" class="rounded" width="280" height="280">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <!-- Product image -->
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <input type="file" accept="image/*" class="form-control @error('voucher_pago') is-invalid @enderror"
                                            id="voucher_pago" name="voucher_pago" onchange="show_voucher_image(event, {{ $venta->id }})">
                                        @error('voucher_pago')
                                        <span class="invalid-feedback" role="alert">
                                            <p><strong>{{ $message }}<a target="_blank" href="https://www.iloveimg.com/es/comprimir-imagen"> Es necesario optimizar la imagen del producto.</strong></a></p>
                                        </span>
                                        @enderror
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

                                <!-- Submit & cancel buttons -->
                                <div class="row">
                                    <div class="col">
                                        <a href="#" data-dismiss="modal" class="btn btn-sm btn-dark">
                                            {{ __('Regresar') }}
                                        </a>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            {{ __('Registrar') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Product create preview -->
<script src="{{ asset('customjs/image_previews/voucher_pago.js') }}"></script>