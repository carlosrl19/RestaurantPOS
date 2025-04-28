function show_user_image_update(event, userId) {
    const user_image_preview_update = document.getElementById('user_image_preview_update_' + userId);
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            user_image_preview_update.src = e.target.result; // Establece la fuente de la imagen a la imagen seleccionada
        }

        reader.readAsDataURL(file); // Lee el archivo como una URL de datos
    } else {
        user_image_preview_update.src = "{{ asset('images/resources/default_user_image.png') }}"; // Restablece a la imagen por defecto si no hay archivo
    }
}
