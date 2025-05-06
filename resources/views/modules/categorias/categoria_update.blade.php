<!-- Modal update categoría -->
<div class="modal fade" id="update_category{{ $categoria->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalCategoryLabel{{ $categoria->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
      <div class="modal-header bg-warning text-dark fw-bold">
        <p class="modal-title" id="modalCategoryLabel{{ $categoria->id }}">Editar Categoría</p>
      </div>
      
      <div class="modal-body">
      <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Campos del formulario -->
    <div class="mb-3">
        <label for="nombre_Categoria{{ $categoria->id }}" class="form-label">
            Nombre de la categoría <span class="text-danger">*</span>
        </label>
        <input type="text"
               class="form-control @error('nombre_Categoria') is-invalid @enderror"
               name="nombre_Categoria"
               value="{{ $categoria->nombre_Categoria }}"
               minlength="3" maxlength="30"
               oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9 ., -Ñ]/g, '')"
               required>
        @error('nombre_Categoria')
            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <!-- Botones -->
    <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-sm btn-danger text-white">Guardar cambios</button>
    </div>
</form>

        </form>
      </div>
    </div>
  </div>
</div>

