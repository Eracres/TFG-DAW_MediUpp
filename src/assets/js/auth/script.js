//import axios from '../../../utils/axios-config.js';

document.addEventListener("DOMContentLoaded", () => {
    // CIERRE DE SESIÓN
    const logoutBtns = document.querySelectorAll(".logout-btn");

    logoutBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            fetch('http://localhost/tfg-daw_mediupp/src/ajax/requests.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'logout' }),
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        console.log(data.message);
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