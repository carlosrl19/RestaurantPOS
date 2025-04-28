function show_product_image_update(event, productId) {
    const product_image_preview_update = document.getElementById('product_image_preview_update_' + productId);
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            product_image_preview_update.src = e.target.result; // Establece la fuente de la imagen a la imagen seleccionada
        }

        reader.readAsDataURL(file); // Lee el archivo como una URL de datos
    } else {
        product_image_preview_update.src = "{{ asset('images/resources/no_image_available.png') }}"; // Restablece a la imagen por defecto si no hay archivo
    }
}
