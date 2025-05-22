<!-- Modal update categoría -->
<div class="modal fade" id="update_category{{ $categoria->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalCategoryLabel{{ $categoria->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-warning text-white fw-bold">
        <p class="modal-title" id="modalCategoryLabel{{ $categoria->id }}">Editar Categoría</p>
      </div>

      <div class="modal-body">
        <form action="{{ route('categorias.update', $categoria->id) }}" method="POST" autocomplete="off" novalidate>
          @method('PUT')
          @csrf

          <div class="mb-3 form-floating">
            <input type="text" class="form-control @error('category_name') is-invalid @enderror"
              id="category_name" name="category_name"
              value="{{ $categoria->category_name }}"
              minlength="3" maxlength="30"
              oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9 ., -Ñ]/g, '')"
              required>
            <label for="category_name">Nombre categoría <span class="text-danger">*</span></label>
            @error('category_name')
            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
            @enderror
          </div>

          <!-- Botones -->
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">Regresar</button>
            <button type="submit" class="btn btn-sm btn-danger text-white">Guardar cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>