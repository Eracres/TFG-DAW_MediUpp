import axios from '/path/to/utils';

document.addEventListener("DOMContentLoaded", () => {
    // CIERRE DE SESIÓN
    const logoutBtns = document.querySelectorAll(".logout-btn");

    logoutBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            axios.post('http://localhost/tfg-daw_mediupp/src/config/ajax_requests.php', { action: 'logout' })
                .then(() => {
                    window.location.href = "/pages/auth/login.php";
                })
                .catch((error) => {
                    console.error("Error al cerrar sesión:", error);
                });
        });
    });
});