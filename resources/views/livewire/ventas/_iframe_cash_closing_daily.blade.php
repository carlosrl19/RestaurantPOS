<div class="modal fade" id="cierre_diario_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header fw-bold">
                <p class="modal-title" id="pdfModalLabel">Ventas (previsualización de cierre diario)</p>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdf-frame-cierre-diario" style="width:100%; min-height: 52rem;" src=""></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Cierre diario scripts -->
<script>
    $('#cierre_diario_modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var url = button.attr('href'); // Extraer la información de los atributos data-*
        var modal = $(this);
        modal.find('#pdf-frame-cierre-diario').attr('src', url);
    });

    $('#cierre_diario_modal').on('hidden.bs.modal', function(e) {
        $(this).find('#pdf-frame-cierre-diario').attr('src', '');
    });
</script>

<script>
    document.getElementById('cierre_diario_btn').addEventListener('click', function() {
        let fecha = document.getElementById('fechaCierre').value;
        // Generar la URL del PDF
        let url = '/generar-factura?fecha=' + fecha;

        // Establecer el src del iframe
        document.getElementById('pdf-frame-cierre-diario').setAttribute('src', url);
    });
</script>

<script>
    // Obtener la fecha actual en el formato YYYY-MM-DD
    var hoy = new Date();

    // Convertir la fecha al formato ISO (YYYY-MM-DD)
    var fechaHoy = hoy.getFullYear() + '-' + ('0' + (hoy.getMonth() + 1)).slice(-2) + '-' + ('0' + hoy.getDate()).slice(-2);

    // Asignar la fecha actual al campo de fecha
    document.getElementById('fechaCierre').value = fechaHoy;
</script>