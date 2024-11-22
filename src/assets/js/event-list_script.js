document.addEventListener("DOMContentLoaded", () => {
    // FUNCIONALIDAD DEL MODAL DE CREAR EVENTO
    const modal = document.querySelector(".modal");
    const modalContainer = document.querySelector(".modal-content");
    const openModalBtn = document.querySelector("#open-modal-btn");
    const closeModalBtns = document.querySelectorAll(".close-modal-btn");
    //const addEventBtn = document.querySelector("#add-event-btn");

    openModalBtn.addEventListener("click", () => {
        modal.classList.add("open");
    });

    closeModalBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            modal.classList.remove("open");
        });
    });

    window.addEventListener("click", (e) => {
        if (e.target === modalContainer) {
            modal.classList.remove("open");
        }
    });
});