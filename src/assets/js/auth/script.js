//import axios from '../../../utils/axios-config.js';

document.addEventListener("DOMContentLoaded", () => {
    // CIERRE DE SESIÓN
    const logoutBtns = document.querySelectorAll(".logout-btn");

    logoutBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            axios.post('/tfg-daw_mediupp/src/ajax/requests.php', { action: 'logout' })
                .then((response) => {
                    const data = response.data;
                    if (data.success) {
                        console.log(data.message);
                        // Redirige al usuario al login
                        window.location.href = data.redirect;
                    } else {
                        console.error('Error en el servidor:', data.message);
                        alert('No se pudo cerrar sesión. Intenta nuevamente.');
                    }
                })
                .catch((error) => {
                    console.error("Error al cerrar sesión:", error);
                });
        });
    });
});