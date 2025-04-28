@if(session('success'))
<div class="toast" id="successToast" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; bottom: 20px; right: 20px; z-index: 9999;">
    <div class="toast-header bg-success text-white fw-bold">
        <strong class="me-auto"><i class="fas fa-bell"></i>&nbsp;Notificación</strong>
    </div>
    <div class="toast-body">
        {{ session('success') }}
    </div>
</div>
@endif

@if(session('error'))
<div class="toast" id="errorToast" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; bottom: 20px; right: 20px; z-index: 9999;">
    <div class="toast-header bg-danger text-white fw-bold">
        <strong class="me-auto"><i class="fas fa-bell"></i>&nbsp;Notificación</strong>
        <button type="button" class="btn-close" data-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        {{ session('error') }}
    </div>
</div>
@endif

@if ($errors->any())
<div class="toast" id="validationErrorsToast" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; bottom: 20px; right: 20px; z-index: 9999;">
    <div class="toast-header bg-danger text-white fw-bold">
        <strong class="me-auto"><i class="fas fa-bell"></i>&nbsp;Error</strong>
        <button type="button" class="btn-close" data-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        Error al realizar acción, intente nuevamente.
    </div>
</div>
@endif

<!-- Toast -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('success'))
        var toast_success = document.getElementById('successToast');
        var toast = new bootstrap.Toast(toast_success);
        toast.show();
        @endif
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('error'))
        var errorToastEl = document.getElementById('errorToast');
        var errorToast = new bootstrap.Toast(errorToastEl);
        errorToast.show();
        @endif

        @if($errors->any())
        var validationErrorsToastEl = document.getElementById('validationErrorsToast');
        var validationErrorsToast = new bootstrap.Toast(validationErrorsToastEl);
        validationErrorsToast.show();
        @endif
    });
</script>