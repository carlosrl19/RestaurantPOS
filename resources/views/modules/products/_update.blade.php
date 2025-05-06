<div class="modal fade" id="update_product{{ $producto->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white fw-bold">
                <p class="modal-title" id="exampleModalLabel">Editar información producto</p>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('productos.update', ['producto' => $producto->id]) }}" enctype="multipart/form-data" novalidate autocomplete="off">
                    @method('PUT')
                    @csrf
                    <div class="m-2">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <!-- Product image -->
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <input type="file" accept="image/*" class="form-control @error('product_image') is-invalid @enderror"
                                            id="product_image" name="product_image" onchange="show_product_image_update(event, {{ $producto->id }})">
                                        @error('product_image')
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

                                <!-- Product name -->
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <div class="form-floating">
                                            <input type="text" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9 ., -Ñ]/g, '')" class="form-control @error('product_name') is-invalid @enderror"
                                                id="product_name"
                                                name="product_name" value="{{ $producto->product_name }}"
                                                minlength="3" maxlength="40">
                                            <label for="product_name" class="form-label">Nombre <span class="text-danger">*</span></label>
                                            @error('product_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 form-floating">
                                    <select class="form-select @error('categoria_id') is-invalid @enderror"
                                            id="categoria_id" name="categoria_id" required>
                                        <option value="" disabled>Seleccione categoría</option>
                                        @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}"
                                            {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre_Categoria }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="categoria_id">Categoría <span class="text-danger">*</span></label>
                                    @error('categoria_id')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>


                                <!-- Price inputs -->
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <div class="form-floating">
                                            <input type="number" class="form-control @error('product_buy_price') is-invalid @enderror"
                                                id="product_buy_price" name="product_buy_price" value="{{ $producto->product_buy_price }}" maxlength="10">
                                            <label for="product_buy_price" class="form-label">Precio compra <span class="text-danger">*</span>
                                                @error('product_buy_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong id="input">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <div class="form-floating">
                                            <input type="number" class="form-control @error('product_sell_price') is-invalid @enderror"
                                                id="product_sell_price" name="product_sell_price" value="{{ $producto->product_sell_price }}"
                                                maxlength="10">
                                            <label for="product_sell_price" class="form-label">Precio venta <span class="text-danger">*</span>
                                                @error('product_sell_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Product description -->
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <div class="form-floating">
                                            <textarea oninput="this.value = this.value.toUpperCase()" class="form-control @error('product_description') is-invalid @enderror"
                                                id="product_description" name="product_description" style="resize: none; height: 100px; font-size: clamp(0.7rem, 3vh, 0.8rem);"
                                                minlength="5" maxlength="100">{{ $producto->product_description }}</textarea>
                                            <label for="product_description" class="form-label">Descripción</label>
                                            @error('product_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock & barcode inputs -->
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <div class="form-floating">
                                            <input type="number" class="form-control @error('product_stock') is-invalid @enderror" id="product_stock" name="product_stock" value="{{ $producto->product_stock }}">
                                            <label for="product_stock" class="form-label">Existencia actual <span class="text-danger">*</span></label>
                                            @error('product_stock')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-floating">
                                            <input type="text" oninput="this.value = this.value.replace(/\D/g, '')" class="form-control @error('product_barcode') is-invalid @enderror"
                                                id="product_barcode" name="product_barcode" value="{{ $producto->product_barcode }}" minlength="4" maxlength="13">
                                            <label for="product_barcode" class="form-label">Código barra</label>
                                            @error('product_barcode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit & cancel buttons -->
                                <div class="row">
                                    <div class="col">
                                        <a href="#" data-dismiss="modal" class="btn btn-sm btn-dark">
                                            {{ __('Regresar') }}
                                        </a>
                                        <button type="submit" class="btn btn-sm btn-warning text-white">
                                            {{ __('Guardar cambios') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Product presentation card -->
                            <div class="col-sm-6">
                                <div class="col-sm-12">
                                    <div class="col-lg-12 d-none d-lg-block">
                                        <div class="card">
                                            <div class="card-header text-bold text-center text-muted">
                                                Presentación del producto
                                            </div>
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <img id="product_image_preview_update_{{ $producto->id }}"
                                                        src="{{ $producto->product_image ? Storage::url('images/products/' . $producto->product_image) : asset('images/resources/no_image_available.png') }}"
                                                        style="object-fit: contain;"
                                                        class="rounded"
                                                        width="280"
                                                        height="280">
                                                </div>
                                            </div>
                                        </div>
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

<!-- Product update preview -->
<script src="{{ asset('customjs/image_previews/product_update.js') }}"></script>