const TEXTS = {
    pending: (senderName, eventTitle) => `${senderName} te ha invitado al evento ${eventTitle}.`,
    accepted: (senderName, eventTitle) => `Has aceptado la invitación de ${senderName} para unirte al evento de ${eventTitle}.`,
    declined: (senderName, eventTitle) => `Has rechazado la invitación de ${senderName}, que te ha invitado a ${eventTitle}.`
};

document.addEventListener('DOMContentLoaded', () => {
    // SISTEMA DE NOTIFICACIONES
    const notificationBtn = document.querySelector(".notification-button");
    const notificationCounter = document.getElementById("notification-counter");
    const notificationBox = document.querySelector(".notification-box");

    loadUserNotifications();

    notificationBtn.addEventListener("click", () => {
        notificationBox.classList.toggle("active");
    });


    // MODO OSCURO
    const themeBtnDarkMode = document.querySelector('.dark-mode');
    if (themeBtnDarkMode) {
        themeBtnDarkMode.addEventListener('click', toggleDarkMode);
    }
});

function toggleDarkMode() {
    document.documentElement.classList.toggle('dark');
}

function loadUserNotifications() {
    $.ajax({
        url: "/config/ajax_requests.php",
        method: "GET",
        success: (response) => {
            const notifications = JSON.parse(response);
            renderNotificationsList(notifications);
        },
        error: (error) => {
            console.log(error);
        }
    });
}

function renderNotificationsList(notifications) {
    const notificationBoxContainer = document.querySelector(".notification-box-container");
    notificationBoxContainer.innerHTML = '';

    if (notifications.length === 0) {
        const notificationText = document.createElement("span");
        notificationText.classList.add("no-notification-text");
        notificationText.textContent = "No tienes invitaciones pendientes";

        notificationBoxContainer.appendChild(notificationText);
        return;
    }

    const notificationList = document.createElement('ul');
    notificationList.classList.add("notification-list");

    notifications.forEach(invitation => {
        const invitationItem = document.createElement('li');
        invitationItem.classList.add("notification-item");
        invitationItem.dataset.id = invitation.id;

        const invitationContent = document.createElement('div');
        invitationContent.classList.add("notification-content");

        const invitationText = document.createElement('span');
        invitationText.classList.add("notification-text");
        invitationText.dataset.senderName = invitation.sender_name;
        invitationText.dataset.eventTitle = invitation.event_title;
        
        if (invitation.status === 'pending') {
            invitationText.textContent = TEXTS.pending(invitation.sender_name, invitation.event_title);
        } else if (invitation.status === 'accepted') {
            invitationText.textContent = TEXTS.accepted(invitation.sender_name, invitation.event_title);
        } else if (invitation.status === 'declined') {
            invitationText.textContent = TEXTS.declined(invitation.sender_name, invitation.event_title);
        }

        invitationContent.appendChild(invitationText);

        if (invitation.status === 'pending') {
            const invitationActions = document.createElement('div');
            invitationActions.classList.add("notification-actions");

            const acceptBtn = document.createElement('button');
            acceptBtn.classList.add("accept-btn");
            acceptBtn.innerHTML = '<i class="fa-solid fa-check"></i>';

            const declineBtn = document.createElement('button');
            declineBtn.classList.add("decline-btn");
            declineBtn.innerHTML = '<i class="fa-solid fa-xmark"></i>';

            invitationActions.appendChild(acceptBtn);
            invitationActions.appendChild(declineBtn);

            invitationContent.appendChild(invitationActions);
        }

        invitationItem.appendChild(invitationContent);

        notificationList.appendChild(invitationItem);
    });

    notificationBoxContainer.appendChild(notificationList);
    setupInvitationButtons();
}

function handleInvitation(action, invitationId) {
    let dataAction = action + "-invitation";
    
    const data = {
        action: dataAction,
        invitation_id: invitationId
    };

    $.ajax({
        url: "/config/ajax_requests.php",
        method: "POST",
        data: data,
        success: () => {
            updateSingleNotificationContent(invitationId, action);
        },
        error: (error) => {
            console.log("Error al actualizar la invitación:", error);
        }
    });
}

function setupInvitationButtons() {
    const acceptInvitationBtns = document.querySelectorAll(".accept-btn");
    const declineInvitationBtns = document.querySelectorAll(".decline-btn");

    acceptInvitationBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            const invitationId = btn.closest('.notification-item').dataset.id;
            handleInvitation("accept", invitationId);
        });
    });

    declineInvitationBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            const invitationId = btn.closest('.notification-item').dataset.id;
            handleInvitation("decline", invitationId);
        });
    });
}

function updateSingleNotificationContent(invitationId, action) {
    const notificationItem = document.querySelector(`.notification-item[data-id="${invitationId}"]`);
    
    if (notificationItem) {
        const invitationText = notificationItem.querySelector('.notification-text');
        
        if (action === 'accept') {
            notificationItem.classList.add('accepted');
            invitationText.textContent = TEXTS.accepted(invitationText.dataset.senderName, invitationText.dataset.eventTitle);
        } else if (action === 'decline') {
            notificationItem.classList.add('declined');
            invitationText.textContent = TEXTS.declined(invitationText.dataset.senderName, invitationText.dataset.eventTitle);
        }

        const notificationActions = notificationItem.querySelector('.notification-actions');
        if (notificationActions) {
            notificationActions.remove();
        }
    }
}

function refreshNotificationBox() {
    loadUserNotifications();
}

function updateNotificationCounter() {
}