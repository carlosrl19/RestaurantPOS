<div class="modal fade" id="cierre_mensual_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header fw-bold">
                <p class="modal-title" id="pdfModalLabel">Compras (previsualización de cierre mensual)</p>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdf-frame-cierre-mensual" style="width:100%; min-height: 52rem;" src=""></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Cierre mensual scripts -->
<script>
    $('#cierre_mensual_modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        const mesSeleccionado = document.getElementById('fechaCierreMensual').value; // Obtener el mes seleccionado
        var url = `/generar-factura-mes-actual?fechaCierreMensual=${mesSeleccionado}`; // Generar la URL

        var modal = $(this);
        modal.find('#pdf-frame-cierre-mensual').attr('src', url); // Establecer el src del iframe
    });

    $('#cierre_mensual_modal').on('hidden.bs.modal', function(e) {
        $(this).find('#pdf-frame-cierre-mensual').attr('src', ''); // Limpiar el src al cerrar
    });
</script>

<script>
    function exportarPDF() {
        const mesSeleccionado = document.getElementById('fechaCierreMensual').value; // Obtener el mes seleccionado
        const url = `/generar-factura-mes-actual-compras?fechaCierreMensual=${mesSeleccionado}`; // Generar la URL

        // Establecer el src del iframe
        document.getElementById('pdf-frame-cierre-mensual').setAttribute('src', url);

        // Abrir el modal
        $('#cierre_mensual_modal').modal('show');
    }

    $('#cierre_mensual_modal').on('hidden.bs.modal', function(e) {
        $(this).find('#pdf-frame-cierre-mensual').attr('src', ''); // Limpiar el src al cerrar
    });
</script>