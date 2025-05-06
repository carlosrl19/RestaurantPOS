<div class="modal fade" id="delete_category{{ $categoria->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deleteCategoryLabel{{ $categoria->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Encabezado -->
      <div class="modal-header bg-danger text-white fw-bold">
        <p class="modal-title" id="deleteCategoryLabel{{ $categoria->id }}">Eliminar categoría</p>
      </div>

      <!-- Formulario -->
      <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST">
    @csrf
    @method('DELETE')

        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-12 text-center">
              <p class="mt-3">
                Está a punto de realizar una acción irreversible. ¿Realmente desea eliminar la categoría
                <strong style="text-transform: uppercase">{{ $categoria->nombre_Categoria }}</strong>?
              </p>
            </div>
          </div>
        </div>

        <!-- Botones -->
        <div class="modal-footer">
          <a href="#" data-dismiss="modal" class="btn btn-sm btn-dark">
            {{ __('Regresar') }}
          </a>
          <button type="submit" class="btn btn-sm btn-danger text-white">
            {{ __('Eliminar') }}
          </button>
        </div>
      </form>

    </div>
  </div>
</div>
