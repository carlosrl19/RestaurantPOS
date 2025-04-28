function fShowPassword() {
    var passwordField = document.getElementById("password");
    var passwordFieldConfirm = document.getElementById("password-confirm");
    var icon = document.querySelector('.icon'); // Selecciona el icono dentro del botón

    if (passwordField.type === "password") {
        passwordField.type = "text"; // Muestra la contraseña
        passwordFieldConfirm.type = "text"; // Muestra la contraseña
        icon.classList.remove('fa-eye-slash'); // Cambia el icono
        icon.classList.add('fa-eye');
    } else {
        passwordField.type = "password"; // Oculta la contraseña
        passwordFieldConfirm.type = "password"; // Oculta la contraseña
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
}
