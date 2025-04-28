function show_voucher_image(event, sellId) {
    const voucher_image_preview = document.getElementById('voucher_image_preview_' + sellId);
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            voucher_image_preview.src = e.target.result; // Establece la fuente de la imagen a la imagen seleccionada
        }

        reader.readAsDataURL(file); // Lee el archivo como una URL de datos
    } else {
        voucher_image_preview.src = "{{ asset('images/resources/receipt.png') }}"; // Restablece a la imagen por defecto si no hay archivo
    }
}
