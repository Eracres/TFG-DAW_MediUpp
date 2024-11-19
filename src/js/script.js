// script.js

function toggleDarkMode() {
    document.documentElement.classList.toggle('dark');
}

document.addEventListener('DOMContentLoaded', () => {
    const modeButton = document.querySelector('.dark-mode');
    if (modeButton) {
        modeButton.addEventListener('click', toggleDarkMode);
        console.log("Evento 'click' asignado al botón de modo oscuro");
    } else {
        console.log("Botón de modo oscuro no encontrado");
    }
});


