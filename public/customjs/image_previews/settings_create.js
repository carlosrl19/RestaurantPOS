function show_system_logo_create(event) {
    // Logo del sistema
    const system_logo_preview_create = document.getElementById('system_logo_preview_create');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            system_logo_preview_create.src = e.target.result; // Establece la fuente de la imagen a la imagen seleccionada
        }

        reader.readAsDataURL(file); // Lee el archivo como una URL de datos
    } else {
        system_logo_preview_create.src = "{{ asset('images/resources/default_user_image.png') }}"; // Restablece a la imagen por defecto si no hay archivo
    }
}

function show_system_logo_reports_create(event) {
    // Logo de reportes
    const system_logo_reports_preview_create = document.getElementById('system_logo_reports_preview_create');
    const file_reports = event.target.files[0];

    if (file_reports) {
        const reader = new FileReader();

        reader.onload = function (e) {
            system_logo_reports_preview_create.src = e.target.result; // Establece la fuente de la imagen a la imagen seleccionada
        }

        reader.readAsDataURL(file_reports); // Lee el archivo como una URL de datos
    } else {
        system_logo_reports_preview_create.src = "{{ asset('images/resources/default_user_image.png') }}"; // Restablece a la imagen por defecto si no hay archivo
    }
}