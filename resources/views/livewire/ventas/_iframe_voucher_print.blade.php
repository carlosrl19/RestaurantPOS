<!-- PDF Viewer Modal -->
<div class="modal fade" style="z-index: 9999;" id="voucher_print" data-backdrop="static" data-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="voucher_printLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fw-bold" id="voucher_printLabel">Factura cliente final</p>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdf-frame-voucher-print" style="width:100%; height:750px;" src=""></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Iframe oculto para impresión automática -->
<iframe id="hidden-print-frame" style="display:none;"></iframe>