//import axios from '../../../utils/axios-config.js';

document.addEventListener("DOMContentLoaded", () => {
    // CIERRE DE SESIÓN
    const logoutBtns = document.querySelectorAll(".logout-btn");

    logoutBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            axios.post('http://localhost/tfg-daw_mediupp/src/config/ajax_requests.php', { action: 'logout' })
                .then((response) => {
                    console.log("Respuesta del servidor:", response.data);
                })
                .catch((error) => {
                    console.error("Error al cerrar sesión:", error);
                });
        });
    });
});