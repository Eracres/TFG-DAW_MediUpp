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
            const participant = e.target.closest(".event-participant");
            const actionsMenu = participant.querySelector(".event-participant-actions-menu");
            // Cerrar otros menús abiertos
            document.querySelectorAll(".event-participant-actions-menu").forEach((menu) => {
                if (menu !== actionsMenu) {
                    menu.classList.add("hidden");
                }
            });
            // Alternar visibilidad del menú actual
            actionsMenu.classList.toggle("hidden");
        });
    });

    document.addEventListener("click", (e) => {
        if (!e.target.closest(".participant-col3")) {
            document.querySelectorAll(".event-participant-actions-menu").forEach((menu) => {
                menu.classList.add("hidden");
            });
        }
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
    let data = {
        action: "get_media_posts",
        event_id: 1
    };

    $.ajax({
        url: "",
        method: "GET",
        success: (response) => {
            const posts = JSON.parse(response);
            posts.forEach(post => {
                printMediaPost(post);
            });
        },
        error: (error) => {

        }
    });
}

function loadChatMessages() {
    let data = {
        action: "get_chat_messages",
        event_id: 1
    };

    $.ajax({
        url: "",
        method: "GET",
        success: (response) => {
            const messages = JSON.parse(response);
            messages.forEach(message => {
                printChatMessage(message);
            });
        },
        error: (error) => {
            
        }
    });
}

// IMPRESIÓN DE POSTS MULTIMEDIA Y MENSAJES DE CHAT
function printMediaPost(post) {
    const mediaPostContainer = document.querySelector("");

    const postElement = document.createElement("div");
    postElement.classList.add("");
    
    // Usuario que sube el post
    const postRow1 = document.createElement("div");
    postRow1.classList.add("");

    const postUserAvatar = document.createElement("div");
    postUserAvatar.classList.add("");

    const postUserAvatarImg = document.createElement("img");
    postUserAvatarImg.classList.add("");

    const postUserName = document.createElement("span");
    postUserName.classList.add("");

    postUserAvatar.appendChild(postUserAvatarImg);
    postRow1.appendChild(postUserAvatar);
    postRow1.appendChild(postUserName);

    // Contenido multimedia
    const postRow2 = document.createElement("div");
    postRow2.classList.add("");

    const postContent = document.createElement("div");
    postContent.classList.add("");

    const postMedia = document.createElement("img");
    postMedia.classList.add("");

    postContent.appendChild(postMedia);
    postRow2.appendChild(postContent);

    postElement.appendChild(postRow1);
    postElement.appendChild(postRow2);

    mediaPostContainer.appendChild(postElement);
}

function printChatMessage(message) {
    const chatContainer = document.querySelector("");

    const messageElement = document.createElement("div");
    messageElement.classList.add("");

    // Usuario que manda el mensaje
    const messageRow1 = document.createElement("div");
    messageRow1.classList.add("");
    
    const messageUserAvatar = document.createElement("div");
    messageUserAvatar.classList.add("");

    const messageUserAvatarImg = document.createElement("img");
    messageUserAvatarImg.classList.add("");

    const messageUserName = document.createElement("span");
    messageUserName.classList.add("");

    messageUserAvatar.appendChild(messageUserAvatarImg);
    messageRow1.appendChild(messageUserAvatar);
    messageRow1.appendChild(messageUserName);
    
    // Mensaje
    const messageRow2 = document.createElement("div");
    messageRow2.classList.add("");

    const messageContent = document.createElement("span");
    messageContent.classList.add("");

    messageRow2.appendChild(messageContent);

    // Fecha y hora
    const messageRow3 = document.createElement("div");
    messageRow3.classList.add("");

    const messageDate = document.createElement("span");
    messageDate.classList.add("");

    messageRow3.appendChild(messageDate);

    messageElement.appendChild(messageRow1);
    messageElement.appendChild(messageRow2);
    messageElement.appendChild(messageRow3);

    chatContainer.appendChild(messageElement);
}