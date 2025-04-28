document.addEventListener('DOMContentLoaded', function () {
    // Toast notification
    var toastEl = document.getElementById('client_booking_toast');
    var lastShown = localStorage.getItem('lastToastShown');
    var now = Date.now();
    var tenSeconds = 5 * 60 * 1000; // 5 minutos de espera

    if (lastShown === null || (now - lastShown > tenSeconds)) {
        var toast = new bootstrap.Toast(toastEl, {
            autohide: false
        });
        toast.show();

        localStorage.setItem('lastToastShown', now);
    }

    // Alert notification
    var alertEl = document.getElementById('client_booking_alert');

    // Verificar si el elemento existe antes de continuar
    if (alertEl) {
        var lastShownAlert = localStorage.getItem('lastAlertShown');
        var now = Date.now();
        var twentyMinutes = 20 * 60 * 1000; // 20 minutos de espera

        if (lastShownAlert === null || (now - lastShownAlert > twentyMinutes)) {
            // Muestra la alerta solo si es visible (no tiene la clase 'd-none')
            if (!alertEl.classList.contains('d-none')) {
                alertEl.style.display = 'block'; // Asegura que se muestre
                localStorage.setItem('lastAlertShown', now);
            }
        } else {
            // Si se mostró recientemente, ocúltala
            alertEl.style.display = 'none';
        }
    }
});