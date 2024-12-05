const MEDIA_SECTION = "media-section";
const CHAT_SECTION = "chat-section";

document.addEventListener("DOMContentLoaded", () => {
    loadContent(MEDIA_SECTION);

    // FUNCIONALIDAD DEL DROPDOWN DEL HEAD
    const userDropdownBtn = document.querySelector(".head-user-dropdow-btn");
    const dropdown = document.querySelector(".head-user-dropdown");
    
    userDropdownBtn.addEventListener("click", () => {
        dropdown.classList.toggle("open");
    });

    // FUNCIONALIDAD DE ACCIONES DE PARTICIPANTES
    const participantActionsBtn = document.querySelectorAll(".participant-actions-btn");

    const closeAllActionMenus = () => {
        document.querySelectorAll(".event-participant-actions-menu").forEach((menu) => {
            menu.classList.remove("open");
        });
    };

    participantActionsBtn.forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.stopPropagation();
            const participant = e.target.closest(".event-participant");
            const actionsMenu = participant.querySelector(".event-participant-actions-menu");
    
            // Cerrar otros menús abiertos
            document.querySelectorAll(".event-participant-actions-menu").forEach((menu) => {
                if (menu !== actionsMenu) {
                    menu.classList.remove("open");
                }
            });
    
            // Alternar visibilidad del menú actual
            actionsMenu.classList.toggle("open");
        });
    });

    document.addEventListener("scroll", () => {
        closeAllActionMenus(); // Cierra los menús al hacer scroll
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
                        let data = {
                            action: "assign-admin",
                            participant_id: participantId,
                            event_id: curretGlobalEventId
                        };

                        fetch('/tfg-daw_mediupp/src/ajax/requests.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(data),
                        })
                            .then((response) => (response.ok ? response.json() : Promise.reject(response)))
                            .then((data) => {
                                if (data.success) {
                                    alert(data.message);
                                    window.location.reload();
                                } else {
                                    alert(data.message || "Ocurrió un error.");
                                }
                            })
                            .catch((error) => {
                                console.error("Error en la solicitud:", error);
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
                        let data = {
                            action: "delete-participant",
                            participant_id: participantId,
                            event_id: curretGlobalEventId
                        };

                        fetch('/tfg-daw_mediupp/src/ajax/requests.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(data),
                        })
                            .then((response) => (response.ok ? response.json() : Promise.reject(response)))
                            .then((data) => {
                                if (data.success) {
                                    alert(data.message);
                                    window.location.reload();
                                } else {
                                    alert(data.message || "Ocurrió un error.");
                                }
                            })
                            .catch((error) => {
                                console.error("Error en la solicitud:", error);
                            });
                    }
                }
            });
        }
    });

    
    // FUNCIONALIDAD DE ELIMINAR UN USUARIO DE UN EVENTO
    const leftEventBtn = document.querySelector(".event-left-button");

    leftEventBtn.addEventListener("click", () => {
        const currentEventId = leftEventBtn.dataset.eventId;
        let data = {
            action: "leave-event",
            event_id: currentEventId
        };

        fetch('/tfg-daw_mediupp/src/ajax/requests.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        })
            .then((response) => response.ok ? response.json() : Promise.reject(response))
            .then((data) => {
                if (data.success) {
                    console.log(data.message);
                    setTimeout(() => window.location.href = data.redirect, 250);
                } else {
                    alert(data.message || 'No se pudo salir del evento. Intenta nuevamente.');
                }
            })
            .catch((error) => console.error("Error al salir del evento:", error));
    });

    const deleteEventBtn = document.querySelector(".event-delete-button");

    if (deleteEventBtn) {
        deleteEventBtn.addEventListener("click", () => {
            const currentEventId = deleteEventBtn.dataset.eventId;
            let data = {
                action: "delete-event",
                event_id: currentEventId
            };

            if (confirm("¿Seguro que deseas eliminar este evento?")) {
                fetch('/tfg-daw_mediupp/src/ajax/requests.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data),
                })
                    .then((response) => response.ok ? response.json() : Promise.reject(response))
                    .then((data) => {
                        if (data.success) {
                            console.log(data.message);
                            setTimeout(() => window.location.href = data.redirect, 250);
                        } else {
                            alert(data.message || 'No se pudo eliminar el evento. Intenta nuevamente.');
                        }
                    })
                    .catch((error) => console.error("Error al eliminar el evento:", error));
            }
        });
    }

    // FUNCIONALIDAD DEL MODAL DE PARTICIPANTES
    const modal = document.querySelector(".modal");
    const modalContainer = document.querySelector(".modal-content");
    const addParticipantBtn = document.getElementById("add-participant-btn");
    const openParticipantModalBtn = document.getElementById("open-participant-modal-btn");
    
    if (openParticipantModalBtn) {
        openParticipantModalBtn.addEventListener("click", () => {
            console.log("Abriendo modal de participantes");
        });
    }

    // window.addEventListener("click", (e) => {
    //     if (e.target === modalContainer) {
    //         modal.classList.remove("open");
    //     }
    // });
    
    const dynamicContent = document.querySelector("#dynamic-content");
    // FUNCIONALIDAD DE CARGA DE SECCIONES Y CONTENIDO (MEDIA POSTS Y CHAT)
    const toggleSectionBtns = document.querySelectorAll(".toggle-section-btn");

    toggleSectionBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            const target = btn.getAttribute("data-target");
            
            loadContent(target);
        });
    });

    // CARGA DINAMICA DE SECCION



    // CHAT Y ENVIO DE MENSAJES
    const chatInput = document.getElementById("chat-input");
    const openEmojisBtn = document.getElementById("open-emojis-btn");

    // openEmojisBtn.addEventListener("click", () => {
    //     // Mostrar emojis
    // });

    // chatInput.addEventListener("keypress", (e) => {
    //     if (e.key === "Enter" && e.shiftKey) {
    //         chatInput.value += "\n";
    //     }
    // });


const sendMessageBar = document.querySelector(".chat-message-bar");

const dynamicContainer = document.querySelector(".dynamic-container");

    dynamicContainer.addEventListener("submit", (event) => {
        if (event.target.matches(".chat-message-bar form")) {
            event.preventDefault(); // Evitar el comportamiento predeterminado del formulario

            const messageInput = document.querySelector("#chat-message-input");
            const message = messageInput.value.trim();

            if (message) {
                sendMessage(message);
                messageInput.value = ""; // Limpiar el campo después de enviar
            }
        }
    });

function sendMessage(message) {
    const data = {
        action: "send-chat-message",
        event_id: currentGlobalEventId,
        message: message
    };

    fetch('/tfg-daw_mediupp/src/ajax/requests.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
        .then((response) => response.json())
        .then((result) => {
            if (result.success) {
                // Mensaje enviado con éxito
                loadContent(CHAT_SECTION);
            } else {
                // Si 'success' es falso, asegúrate de que 'result.error' exista
                console.error("Error al enviar el mensaje");
            }
        })
        .catch((error) => {
            console.error("Error en la solicitud de envío de mensaje:", error);
        });
}

function loadContent(section) {

    const dynamicContainer = document.querySelector(".dynamic-container");
    dynamicContainer.innerHTML = '';

    if (section === MEDIA_SECTION) {;
        loadMediaPosts();
        const postModalBtnHTML = `
            <div class="open-post-modal-btn">
                <button id="create-post-btn" class="btn btn-primary">Crear Post</button>
            </div>
        `;
        dynamicContainer.insertAdjacentHTML('beforeend', postModalBtnHTML);
    } else if (section === CHAT_SECTION) {
        loadChatMessages();
        const chatMessageBarHTML = `
            <div class="chat-message-bar">
                <form action="" method="post">
                    <input type="text" id="chat-message-input" placeholder="Escribe un mensaje..." />
                    <button id="send-message-btn" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        `;
        dynamicContainer.insertAdjacentHTML('beforeend', chatMessageBarHTML);
    }
}

// CARGA DE POSTS MULTIMEDIA Y MENSAJES DE CHAT
function loadMediaPosts() {
    let data = {
        action: "get-media-posts",
        event_id: currentGlobalEventId
    };

    fetch('/tfg-daw_mediupp/src/ajax/requests.php?' + new URLSearchParams(data).toString())
        .then((response) => response.json())  // Asegúrate de que la respuesta se convierta a JSON
        .then((posts) => {
            posts.forEach(post => {
                printMediaPost(post);
            });
        })
        .catch((error) => {
            console.log("Error al cargar las publicaciones de medios:", error);
        });
}

function loadChatMessages() {
    let data = {
        action: "get-chat-messages",
        event_id: currentGlobalEventId
    };

    fetch('/tfg-daw_mediupp/src/ajax/requests.php?' + new URLSearchParams(data).toString())
        .then((response) => response.json())  // Asegúrate de que la respuesta se convierta a JSON
        .then((messages) => {
            messages.forEach(message => {
                printChatMessage(message);
            });
        })
        .catch((error) => {
            console.log("Error al cargar los mensajes del chat:", error);
        });
}

// IMPRESIÓN DE POSTS MULTIMEDIA Y MENSAJES DE CHAT
function printMediaPost(post) {
    const mediaPostContainer = document.querySelector(".dynamic-container");

    let data = {
        action: "get-user-info",
        user_id: post.user_id
    };

    fetch('/tfg-daw_mediupp/src/ajax/requests.php?' + new URLSearchParams(data).toString())
        .then((response) => response.json())  // Asegúrate de que la respuesta se convierta a JSON
        .then((user) => {
            let user_pfp = user.pfp_src || 'default-avatar.png';
            let user_name = user.usern || 'Desconocido';

            const isUserMessage = post.user_id === currentUserId;
            const postAlignmentClass = isUserPost ? 'user-post' : 'other-post';

            const postHTML = `
                <div class="post-element ${postAlignmentClass}">
                    <div class="post-row-1">
                        <div class="post-user-avatar">
                            <img src="${user_pfp}" alt="User Avatar">
                        </div>
                        <span class="post-user-name">${user_name}</span>
                    </div>
                    <div class="post-row-2">
                        <div class="post-content">
                            <img src="${post.file_src}" alt="">
                        </div>
                    </div>
                    <div class="post-row-3">
                        <span class="post-date">${post.created_at}</span>
                    
                </div>
            `;

    mediaPostContainer.innerHTML += postHTML;
        })
        .catch((error) => {
            console.log("Error al cargar la info del user:", error);
        }); 
}


function printChatMessage(message) {
    const chatContainer = document.querySelector(".dynamic-container");
    let data = {
        action: "get-user-info",
        user_id: message.user_id
    };

    fetch('/tfg-daw_mediupp/src/ajax/requests.php?' + new URLSearchParams(data).toString())
        .then((response) => response.json())  // Asegúrate de que la respuesta se convierta a JSON
        .then((user) => {
            let user_pfp = user.pfp_src || 'default-avatar.png';
            let user_name = user.usern || 'Desconocido';

            const isUserMessage = message.user_id === currentUserId;
            const messageAlignmentClass = isUserMessage ? 'user-message' : 'other-message';

            const messageHTML = `
                <div class="message-element ${messageAlignmentClass}">
                    <div class="message-row-1">
                        <div class="message-user-avatar">
                            <img src="${user_pfp}" alt="User Avatar">
                        </div>
                        <span class="message-user-name">@${user_name}</span>
                    </div>
                    <div class="message-row-2">
                        <span class="message-content">${message.message}</span>
                    </div>
                    <div class="message-row-3">
                        <span class="message-date">${message.created_at}</span>
                    </div>
                </div>
            `;

            chatContainer.innerHTML += messageHTML;
        })
        .catch((error) => {
            console.log("Error al cargar la info del user:", error);
        });

    
}

const openPostModalBtn = document.querySelector(".open-post-modal-btn");
const filesModal = document.querySelector(".files-modal-container");

    // Mostrar el modal
    openPostModalBtn.addEventListener("click", () => {
        filesModal.classList.toggle("open"); // Mostrar el modal
    });
});