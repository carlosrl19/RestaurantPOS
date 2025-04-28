function show_product_image_create(event) {
    const product_image_preview_create = document.getElementById('product_image_preview_create');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            product_image_preview_create.src = e.target.result; // Establece la fuente de la imagen a la imagen seleccionada
        }

        reader.readAsDataURL(file); // Lee el archivo como una URL de datos
    } else {
        product_image_preview_create.src = "{{ asset('images/resources/no_image_available.png') }}"; // Restablece a la imagen por defecto si no hay archivo
    }
}