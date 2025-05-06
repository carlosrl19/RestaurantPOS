<!-- Modal -->
<div class="modal fade" id="create_category" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalCategoryLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
      <div class="modal-header bg-danger text-white fw-bold">
        <p class="modal-title" id="modalCategoryLabel">Nueva Categoría</p>
      </div>
      
      <div class="modal-body">
        <form action="{{ route('categorias.store') }}" method="POST" novalidate autocomplete="off">
          @csrf
          
          <!-- Nombre de la categoría -->
          <div class="mb-3 form-floating">
            <input type="text" class="form-control @error('nombre_Categoria') is-invalid @enderror"
                   id="nombre_Categoria" name="nombre_Categoria"
                   value="{{ old('nombre_Categoria') }}"
                   minlength="3" maxlength="30"
                   oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9 ., -Ñ]/g, '')"
                   required>
            <label for="nombre_Categoria">Nombre de la categoría <span class="text-danger">*</span></label>
            @error('nombre_Categoria')
              <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
            @enderror
          </div>
          <!-- Botones -->
          <div class="d-flex justify-content-between">
            <a href="#" data-dismiss="modal" class="btn btn-sm btn-dark">Cancelar</a>
            <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
