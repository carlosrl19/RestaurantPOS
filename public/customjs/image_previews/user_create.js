function show_user_image_create(event) {
    const user_image_preview_create = document.getElementById('user_image_preview_create');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            user_image_preview_create.src = e.target.result; // Establece la fuente de la imagen a la imagen seleccionada
        }

        reader.readAsDataURL(file); // Lee el archivo como una URL de datos
    } else {
        user_image_preview_create.src = "{{ asset('images/resources/default_user_image.png') }}"; // Restablece a la imagen por defecto si no hay archivo
    }
}