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
            <input type="text" class="form-control @error('category_name') is-invalid @enderror"
              id="category_name" name="category_name"
              value="{{ old('category_name') }}"
              minlength="3" maxlength="30"
              oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9 ., -Ñ]/g, '')"
              required>
            <label for="category_name">Nombre categoría <span class="text-danger">*</span></label>
            @error('category_name')
            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
            @enderror
          </div>
          
          <!-- Submit buttons -->
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
        </form>
      </div>
    </div>
  </div>
</div>