function carouselVoucherViewer(event) {
    var carouselImages = document.getElementById("carousel-creditnotes-images");
    carouselImages.innerHTML = ""; // Limpiar el contenedor antes de agregar nuevas imágenes

    var files = event.target.files; // Obtener todos los archivos seleccionados
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();

        reader.onload = (function (file, index) {
            return function (e) {

                // Crear un nuevo elemento de imagen
                var carouselItem = document.createElement("div");
                carouselItem.className =
                    "carousel-item" + (index === 0 ? " active" : "");
                var img = document.createElement("img");
                img.src = e.target.result;
                img.className = "d-block w-100";
                img.style.minHeight = "105px";
                img.style.maxHeight = "105px";
                img.style.borderRadius = "5px";
                img.style.objectFit = "cover";

                // Agregar evento de clic para abrir la vista previa
                img.onclick = function () {
                    document.getElementById("previewImageCreditNote").src = e.target.result;
                    var modal = new bootstrap.Modal(document.getElementById('previewImageCreditNoteModal'));
                    modal.show();
                };

                carouselItem.appendChild(img);
                carouselImages.appendChild(carouselItem);
            };
        })(file, i);

        reader.readAsDataURL(file);
    }
}
