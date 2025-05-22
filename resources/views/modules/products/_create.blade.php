<!-- Modal -->
<div class="modal fade" id="create_product" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white fw-bold">
        <p class="modal-title" id="exampleModalLabel">Nuevo producto</p>
      </div>

      <div class="modal-body">
        <form action="{{ route('productos.store')}}" method="POST" enctype="multipart/form-data" novalidate autocomplete="off">
          @csrf
          <div class="m-2">
            <div class="row g-3">

              <!-- Columna izquierda (Formulario) -->
              <div class="col-sm-6">
                <!-- Imagen -->
                <div class="mb-3">
                  <input type="file" accept="image/*" class="form-control @error('product_image') is-invalid @enderror"
                    id="product_image" name="product_image" onchange="show_product_image_create(event)">
                  @error('product_image')
                  <span class="invalid-feedback" role="alert">
                    <p><strong>{{ $message }} <a target="_blank" href="https://www.iloveimg.com/es/comprimir-imagen">Optimiza la imagen aquí</a></strong></p>
                  </span>
                  @enderror
                </div>

                <!-- Nombre -->
                <div class="mb-3 form-floating">
                  <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                    id="product_name" name="product_name" value="{{ old('product_name') }}"
                    minlength="3" maxlength="40"
                    oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9 ., -Ñ]/g, '')">
                  <label for="product_name">Nombre <span class="text-danger">*</span></label>
                  @error('product_name')
                  <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>

                <!-- Categoría -->
                <div class="mb-3 form-floating">
                  <select class="form-select @error('categoria_id') is-invalid @enderror"
                    id="categoria_id" name="categoria_id" required>
                    <option value="" disabled selected>Seleccione categoría</option>
                    @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->category_name }}</option>
                    @endforeach
                  </select>
                  <label for="categoria_id">Categoría <span class="text-danger">*</span></label>
                  @error('categoria_id')
                  <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>

                <div class="row mb-3">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="form-floating">
                      <input type="number" class="form-control @error('product_buy_price') is-invalid @enderror"
                        id="product_buy_price" name="product_buy_price" value="{{ old('product_buy_price') }}" maxlength="10">
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
                        id="product_sell_price" name="product_sell_price" value="{{ old('product_sell_price') }}"
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

                <!-- Descripción -->
                <div class="mb-3 form-floating">
                  <textarea class="form-control @error('product_description') is-invalid @enderror"
                    id="product_description" name="product_description"
                    style="resize: none; height: 100px; font-size: clamp(0.7rem, 3vh, 0.8rem);"
                    minlength="5" maxlength="100"
                    oninput="this.value = this.value.toUpperCase()">{{ old('product_description') }}</textarea>
                  <label for="product_description">Descripción</label>
                  @error('product_description')
                  <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>

                <!-- Existencia y código de barras -->
                <div class="row mb-3">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="form-floating">
                      <input type="number" class="form-control @error('product_stock') is-invalid @enderror"
                        id="product_stock" name="product_stock" value="{{ old('product_stock') }}" maxlength="10">
                      <label for="product_stock" class="form-label">Existencia actual <span class="text-danger">*</span></label>
                      @error('product_stock')
                      <span class="invalid-feedback" role="alert">
                        <strong id="input">{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="form-floating">
                      <input type="text" class="form-control @error('product_barcode') is-invalid @enderror"
                        id="product_barcode" name="product_barcode" value="{{ old('product_barcode') }}"
                        minlength="4" maxlength="13">
                      <label for="product_barcode" class="form-label">Código barra</label>
                      @error('product_barcode')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>
                </div>

                <!-- Botones -->
                <div class="d-flex justify-content-between">
                  <a href="#" data-dismiss="modal" class="btn btn-sm btn-dark">Regresar</a>
                  <button type="submit" class="btn btn-sm btn-primary">Registrar</button>
                </div>
              </div>

              <!-- Columna derecha (Vista previa) -->
              <div class="col-sm-6">
                <div class="card">
                  <div class="card-header text-bold text-center text-muted">
                    Presentación del producto
                  </div>
                  <div class="card-body text-center">
                    <img id="product_image_preview_create"
                      src="{{ Storage::url('images/resources/no_image_available.png') }}"
                      class="rounded" style="object-fit: contain;" width="280" height="280">
                  </div>
                </div>
              </div>
            </div> <!-- .row -->
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal de advertencia por tamaño de imagen -->
<div class="modal fade" id="myModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-danger-double">
      <div class="modal-header bg-danger-dark" style="color: white;">
        <p class="modal-title" id="exampleModalLabel">Advertencia</p>
      </div>
      <div class="modal-body">
        El tamaño máximo permitido para las imágenes de productos es 8 MB. Intente
        <a target="_blank" href="https://www.iloveimg.com/es/comprimir-imagen">optimizar la imagen</a> o usar otra de menor peso.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- JS para previsualización -->
<script src="{{ asset('customjs/image_previews/product_create.js') }}"></script>