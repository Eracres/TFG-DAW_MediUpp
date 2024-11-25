const MEDIA_SECTION = "media-section";
const CHAT_SECTION = "chat-section";

document.addEventListener("DOMContentLoaded", () => {
    // FUNCIONALIDAD DEL DROPDOWN DEL HEAD
    const userDropdownBtn = document.querySelector(".head-user-dropdow-btn");
    
    userDropdownBtn.addEventListener("click", () => {
        const dropdown = document.querySelector(".head-user-dropdown");
        dropdown.classList.toggle("open");
    });

    // FUNCIONALIDAD DE ACCIONES DE PARTICIPANTES
    const participantActionsBtn = document.querySelectorAll(".participant-actions-btn");

    participantActionsBtn.forEach(btn => {
        btn.addEventListener("click", (e) => {
            const actionsMenu = e.target.closest(".participant-col3").querySelector(".event-participant-actions-menu");
            actionsMenu.classList.toggle("hidden");
        });
    });

    // FUNCIONALIDAD DE ASIGNAR ADMINISTRADOR O ELIMINAR A UN PARTICIPANTE
    const assignAdminBtns = document.querySelectorAll(".assign-participant-admin-btn");
    const deleteParticipantBtns = document.querySelectorAll(".delete-participant-btn");

    assignAdminBtns.forEach((btn) => {
        if (!btn.disabled) {
            btn.addEventListener("click", (e) => {
                const participantElement = e.target.closest(".event-participant");
                const participantId = participantElement.dataset.participantId;

                if (participantId) {
                    if (confirm("¿Seguro que deseas asignarle como adminitrador?")) {
                        $.ajax({
                            url: "/path/to/assign-admin-endpoint.php",
                            method: "POST",
                            data: { participant_id: participantId },
                            success: (response) => {
                                alert("Administrador asignado con éxito.");
                                location.reload();
                            },
                            error: (error) => {
                                console.error("Error asignando administrador:", error);
                            },
                        });
                    }
                }
            });
        }
    });

    deleteParticipantBtns.forEach((btn) => {
        if (!btn.disabled) {
            btn.addEventListener("click", (e) => {
                const participantElement = e.target.closest(".event-participant");
                const participantId = participantElement.dataset.participantId;

                if (participantId) {
                    if (confirm("¿Seguro que deseas eliminar a este participante?")) {
                        $.ajax({
                            url: "",
                            method: "POST",
                            data: { participant_id: participantId },
                            success: (response) => {
                                alert("Participante eliminado.");
                                participantElement.remove();
                            },
                            error: (error) => {
                                console.error("Error eliminando participante:", error);
                            },
                        });
                    }
                }
            });
        }
    });

    
    // FUNCIONALIDAD DE ELIMINAR UN USUARIO DE UN EVENTO
    const leftEventBtn = document.querySelector(".event-left-button");

    leftEventBtn.addEventListener("click", () => {
        $.ajax({
            url: "",
            method: "POST",
            data: {  },
            success: (response) => {
                
            },
            error: (error) => {

            }
        });
    });

    // FUNCIONALIDAD DEL MODAL DE PARTICIPANTES
    const modal = document.querySelector(".modal");
    const modalContainer = document.querySelector(".modal-content");
    const addParticipantBtn = document.getElementById("add-participant-btn");
    const openParticipantModalBtn = document.getElementById("open-participant-modal-btn");
    
    openParticipantModalBtn.addEventListener("click", () => {
        modal.classList.add("open");
    });

    addParticipantBtn.addEventListener("click", () => {
        
    });

    window.addEventListener("click", (e) => {
        if (e.target === modalContainer) {
            modal.classList.remove("open");
        }
    });

    // FUNCIONALIDAD DE CARGA DE SECCIONES Y CONTENIDO (MEDIA POSTS Y CHAT)
    const toggleSectionBtns = document.querySelectorAll(".toggle-section-btn");

    toggleSectionBtns.forEach(V => {
        btn.addEventListener("click", () => {
            const target = btn.getAttribute("data-target");
            loadContent(target);
        });
    });

    // CHAT Y ENVIO DE MENSAJES
    const chatInput = document.getElementById("chat-input");
    const openEmojisBtn = document.getElementById("open-emojis-btn");
    const sendBtn = document.querySelector(".send-message-btn");

    openEmojisBtn.addEventListener("click", () => {
        // Mostrar emojis
    });

    sendBtn.addEventListener("click", () => {
        const message = chatInput.value.trim();
        if (message) {
            $.ajax({
                url: "",
                method: "POST",
                data: {  },
                success: (response) => {

                },
                error: (error) => {
                    
                }
            });
        }
    });

    chatInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter" && !e.shiftKey) {
            sendButton.click();
        }

        if (e.key === "Enter" && e.shiftKey) {
            chatInput.value += "\n";
        }
    });

});

function loadContent(section) {
    // Dependiendo del botón que se preosione, cargamos su contenido
    if (section === MEDIA_SECTION) {
        loadMediaPosts();
    } else if (section === CHAT_SECTION) {
        loadChatMessages();
    }
}

// CARGA DE POSTS MULTIMEDIA Y MENSAJES DE CHAT
function loadMediaPosts() {

    $.ajax({
        url: "",
        method: "GET",
        success: (response) => {

        },
        error: (error) => {
            
        }
    });
}

function loadChatMessages() {

    $.ajax({
        url: "",
        method: "GET",
        success: (response) => {

        },
        error: (error) => {
            
        }
    });
}

// IMPRESIÓN DE POSTS MULTIMEDIA Y MENSAJES DE CHAT
function printMediaPost(post) {
    
}

function printChatMessage(message) {
    
}