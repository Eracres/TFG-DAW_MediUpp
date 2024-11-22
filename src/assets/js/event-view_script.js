const MEDIA_SECTION = "media-section";
const CHAT_SECTION = "chat-section";

document.addEventListener("DOMContentLoaded", () => {
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
function printMediaPosts(posts) {
    posts.forEach(post => {
        
    });
}

function printChatMessages(messages) {
    messages.forEach(message => {
        
    });
}