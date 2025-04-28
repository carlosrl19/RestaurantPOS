<div class="modal fade" id="modal-errors" data-backdrop="static" data-keyboard="false"
    tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header bg-danger text-white fw-bold">
                <p class="modal-title"><i class="fas fa-fw fa-bell"></i>&nbsp;Hubo uno o más errores...</p>
            </div>
            <div class="modal-body">
                @foreach ($errors->all() as $error)
                <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px;" class="text-warning" />&nbsp;{{$error}}<br>
                @endforeach
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>