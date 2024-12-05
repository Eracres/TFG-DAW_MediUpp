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
                .then((response) => response.ok ? response.json() : Promise.reject(response))
                .then((data) => {
                    if (data.success) {
                        console.log(data.message);
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 250);
                    } else {
                        alert('No se pudo cerrar sesión. Intenta nuevamente.');
                    }
                })
                .catch((error) => {
                    console.error("Error al cerrar sesión:", error);
                });
        });
    });
});