$(document).ready(function () {
    // Mostrar todos los toasts
    $(".toast").each(function () {
        setTimeout(() => {
            $(this).fadeOut(600); // Desvanece el toast en 300 ms
        }, 4000); // Tiempo antes de ocultar (3000 ms)
    });
});