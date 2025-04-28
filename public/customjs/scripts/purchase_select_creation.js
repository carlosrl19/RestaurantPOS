function funcionObtenerCosto() {
    var select = document.getElementById("producto_id");
    var valor = select.value;

    const productosData = productos; // Accede a los datos pasados desde Blade

    for (let i = 0; i < productosData.length; i++) {
        if (valor == productosData[i].id) {
            // Obtener product_buy_price
            var inputPrecioCompra = document.getElementById("product_buy_price");
            inputPrecioCompra.value = productosData[i].product_buy_price;

            // Obtener existencia
            var inputStock = document.getElementById("product_stock");
            inputStock.value = productosData[i].product_stock;
        }
    }
}

function provedor() {
    $('#id_prove').val($('#proveedor_id').val());
}

// Llama a funcionObtenerCosto cuando sea necesario (por ejemplo al cambiar el select)
document.addEventListener('DOMContentLoaded', function () {
    const productoSelect = document.getElementById("producto_id");

    if (productoSelect) {
        productoSelect.addEventListener('change', funcionObtenerCosto);

        // Llamar una vez al cargar si es necesario establecer valores iniciales.
        funcionObtenerCosto();

        provedor(); // Si también se necesita ejecutar esta función inicialmente.
    }
});

function mostrarImagen(select) {
    const selectedOption = select.options[select.selectedIndex];
    const imagenUrl = selectedOption.getAttribute('data-imagen');
    const imagenElement = document.getElementById('product_image');

    if (imagenUrl && imagenUrl.trim() !== '') {
        // Verifica si la imagen existe realmente haciendo una petición
        const img = new Image();
        img.onload = function () {
            imagenElement.src = `${rutaImagenesProductos}/${imagenUrl}`;
        };
        img.onerror = function () {
            // Si no se encuentra la imagen, carga la imagen por defecto
            imagenElement.src = rutaImagenPorDefecto;
        };
        img.src = `${rutaImagenesProductos}/${imagenUrl}`;
    } else {
        // Si no hay imagen, carga la imagem por defecto
        imagenElement.src = rutaImagenPorDefecto;
    }
}

// Llama a mostrarImagen cuando sea necesario (por ejemplo al cambiar el select)
document.addEventListener('DOMContentLoaded', function () {
    const productoSelect = document.getElementById("producto_id");

    if (productoSelect) {
        productoSelect.addEventListener('change', function (e) {
            funcionObtenerCosto(); // Llamar función anterior también si es necesario.
            mostrarImagen(this);
            provedor(); // Si también se necesita ejecutar esta función inicialmente.

            // Puedes llamar estas funciones una vez al cargar si es necesario establecer valores iniciales.
            funcionObtenerCosto();
            mostrarImagen(productoSelect);

            provedor();
        });

        // Inicializar valores iniciales:
        funcionObtenerCosto();
        mostrarImagen(productoSelect);
    }
});
