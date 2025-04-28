<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="font-size: clamp(0.8rem, 6vw, 1rem); background: #4e73df; color: white;">
                <p class="modal-title" id="exampleModalLabel">¿Listo para salir?</p>
            </div>
            <div class="modal-body" style="font-size: clamp(0.7rem, 6vw, 0.82rem);">Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión actual.</div>
            <div class="modal-footer" style="font-size: clamp(0.7rem, 6vw, 1rem);">
                <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-danger" type="submit">
                        {{ __('Cerrar sesión') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>