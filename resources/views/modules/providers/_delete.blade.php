<div class="modal fade" id="delete_provider{{ $proveedor->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white fw-bold">
                <p class="modal-title" id="staticBackdropLabel">Eliminar proveedor</p>
            </div>

            <form action="{{ route('proveedor.destroy',$proveedor->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    Está a punto de realizar una acción irreversible. ¿Realmente desea eliminar el proveedor <strong style="text-transform: uppercase">{{ $proveedor->provider_company_name }}?</strong>?
                </div>
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