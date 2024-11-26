document.addEventListener("DOMContentLoaded", () => {
    // FUNCIONALIDAD DEL MODAL DE CREAR EVENTO
    const modal = document.querySelector(".modal");
    const modalContainer = document.querySelector(".modal-content");
    const modalForm = document.querySelector("form");
    const openModalBtn = document.querySelector("#open-modal-btn");
    const closeModalBtns = document.querySelectorAll(".close-modal-btn");
    //const addEventBtn = document.querySelector("#add-event-btn");

    openModalBtn.addEventListener("click", () => {
        modal.classList.add("open");
    });

    closeModalBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            e.preventDefault();

            /*const errorSpans = document.querySelectorAll(".form-error-text");
            errorSpans.forEach(span => span.remove());

            modalForm.reset();*/

            modal.classList.remove("open");
        });
    });

    window.addEventListener("click", (e) => {
        if (modal.classList.contains("open") && !modalContainer.contains(e.target)) {
            modal.classList.remove("open");
        }
    });
});