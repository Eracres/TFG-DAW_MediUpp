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

    // CIERRE DE SESIÓN
    const logoutBtn = document.querySelector("#logout-btn");

    logoutBtn.addEventListener("click", () => {
        $.ajax({
            url: "/logout",
            method: "POST",
            data: { action: 'logout' },
            success: (response) => {
                window.location.href = "/login";
            },
            error: (error) => {
                console.error("Error al cerrar sesión:", error);
            }
        });
    });
});