document.addEventListener('DOMContentLoaded', () => {
    // SISTEMA DE NOTIFICACIONES
    const notificationBtn = document.querySelector(".notification-button");
    const notificationCounter = document.getElementById("notification-counter");
    const notificationBox = document.querySelector(".notification-box");

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

function loadUserNotifications(userId) {

    $.ajax({
        url: "/config/ajax_requests.php",
        method: "POST",
        data: { user_id: userId },
        success: () => {
            
        },
        error: (error) => {
            
        }
    });
}

function handleInvitation(action, eventId) {
    action += "-invitation";
    
    const data = {
        action: action,
        event_id: eventId
    };

    $.ajax({
        url: "/config/ajax_requests.php",
        method: "POST",
        data: data,
        success: () => {
            
        },
        error: (error) => {
            
        }
    });

}

function attachInvitationActions() {
    const acceptInvitationBtns = document.querySelectorAll(".accept-btn");
    const declineInvitationBtns = document.querySelectorAll(".decline-btn");

    acceptInvitationBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            handleInvitation("accept", btn.dataset.id);
        });
    });

    declineInvitationBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            handleInvitation("decline", btn.dataset.id);
        });
    });
}

function refreshNotificationBox() {

}

function updateNotificationCounter() {

}
            