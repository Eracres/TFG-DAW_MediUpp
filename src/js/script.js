// script.js
console.log("El script de JavaScript se ha cargado correctamente");

function toggleDarkMode() {
    document.documentElement.classList.toggle('dark');
    
    const modeButton = document.querySelector('.dark-mode');
    if (document.documentElement.classList.contains('dark')) {
        modeButton.textContent = 'Modo Claro';
    } else {
        modeButton.textContent = 'Modo Oscuro';
    }
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
