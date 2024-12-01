<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    // SOLICITUDES AJAX PARA EL FUNCIONAMIENTO DEL PROYECTO
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // CERRAR SESIÓN
        if (isset($_POST['action']) && $_POST['action'] === 'logout') {
            logout();
        }

        // INVITAR A UN USUARIO A UN EVENTO
        if (isset($_POST['action']) && $_POST['action'] === 'send-invitation' && isset($_POST['event_id']) && isset($_POST['invited_user_id'])) {
            $event_id = $_POST['event_id'];
            $invited_user_id = $_POST['invited_user_id'];
            $sender_user_id = getLoggedUser()['id'];

            createEventInvitation($event_id, $invited_user_id, getLoggedUser()['id']);

        }

        // ACEPTAR O RECHAZAR INVITACIÓN
        if (isset($_POST['action']) && $_POST['action'] === 'accept-invitation' && isset($_POST['invitation_id'])) {
            $invitation_id = $_POST['invitation_id'];
            $invited_user_id = getLoggedUser()['id'];
            
            acceptEventInvitation($invitation_id, $invited_user_id);
        }

        if (isset($_POST['action']) && $_POST['action'] === 'decline-invitation' && isset($_POST['invitation_id'])) {
            $invitation_id = $_POST['invitation_id'];
            $invited_user_id = getLoggedUser()['id'];
            
            declineEventInvitation($invitation_id, $invited_user_id);
        }

        // ENVIA MENSAJE DE CHAT
        if (isset($_POST['action']) && $_POST['action'] === 'send-chat-message' && isset($_POST['event_id']) && isset($_POST['message'])) {
            $event_id = $_POST['event_id'];
            $message = $_POST['message'];
            $sender_user_id = getLoggedUser()['id'];

            sendMessage($sender_user_id, $event_id, $message);
        }

        // SALIR DE UN EVENTO
        if (isset($_POST['action']) && $_POST['action'] === 'leave-event' && isset($_POST['event_id'])) {
            $event_id = $_POST['event_id'];
            $user_id = getLoggedUser()['id'];

            deleteUserFromEvent($event_id, $user_id);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // OBTENER INVITACIONES
        if (isset($_GET['action']) && $_GET['action'] === 'get-invitations') {
            $user_id = getLoggedUser()['id'];

            $invitations = getUserInvitations($user_id);

            echo json_encode($invitations);
            exit;
        }

        // OBTEBER POSTS DE UN EVENTO
        if (isset($_GET['action']) && $_GET['action'] === 'get-media-posts' && isset($_GET['event_id'])) {
            $event_id = $_GET['event_id'];

            $media_posts = getEventMediaPosts($event_id);

            echo json_encode($media_posts);
            exit;
        }

        // OBTENER MENSAJES DE CHAT DE UN EVENTO
        if (isset($_GET['action']) && $_GET['action'] === 'get-chat-messages' && isset($_GET['event_id'])) {
            $event_id = $_GET['event_id'];

            $chat_messages = getEventChatMessages($event_id);

            echo json_encode($chat_messages);
            exit;
        }
    }