<div class="modal fade" id="modal_agregar_detalle" data-backdrop="static"
    data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header fw-bold text-white" style="background-color: #b02a37;">
                <p class="modal-title" id="staticBackdropLabel">Agregar productos</p>
            </div>
            <form action="{{ route('compras.store') }}" method="POST" novalidate autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <input type="text" name="compra_id" id="compra_id" value="{{ $compra->id }}" hidden>
                            <input type="text" id="id_prove" name="id_prove" hidden>

                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <select class="@error('producto_id') is-invalid @enderror"
                                        id="producto_id" required name="producto_id" onchange="funcionObtenerCosto(); mostrarImagen(this)">
                                        <option value="" disabled selected>Seleccione el producto a comprar</option>
                                        @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}"
                                            data-imagen="{{ $producto->product_image }}"
                                            {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                            {{$producto['product_name']}}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('producto_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <input type="number" min="1" class="form-control form-control @error('product_buy_price') is-invalid @enderror" id="cantidad_detalle_compra"
                                        name="cantidad_detalle_compra" value="" required>
                                    <label for="cantidad_detalle_compra" class="form-label">Cantidad compra <span class="text-danger">*</span></label>
                                    @error('cantidad_detalle_compra')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="text-muted form-control @error('product_buy_price') is-invalid @enderror"
                                        id="product_buy_price"
                                        name="product_buy_price" value="{{ old('product_buy_price') }}" required

                                        readonly
                                        style="background-color: white; border-left: 4px solid #4e73df;">
                                    <label for="product_buy_price" class="text-secondary-d1">Precio compra</label>
                                    @error('product_buy_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="text-muted form-control @error('product_stock') is-invalid @enderror"
                                        id="product_stock"
                                        name="product_stock" value="{{ old('product_stock') }}" required

                                        readonly
                                        style="background-color: white; border-left: 4px solid #4e73df;">
                                    <label for="product_stock" class="text-secondary-d1">Existencia actual</label>
                                    @error('product_stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 d-none d-sm-none d-md-block d-lg-block">
                            <div class="card">
                                <div class="card-header text-bold text-center text-muted">
                                    Presentación del producto
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <img id="product_image" src="{{ asset('images/resources/no_image_available.png') }}" style="object-fit: contain;" class="rounded" width="155" height="155">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col">
                        <button type="button" class="btn btn-sm" style="background-color: #2c3034; color: #fff;" data-dismiss="modal">Cancelar
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary">Continuar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>