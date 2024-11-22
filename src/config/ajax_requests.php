<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    // SOLICITUDES AJAX PARA EL FUNCIONAMIENTO DEL PROYECTO
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // CERRAR SESIÓN
        if (isset($_POST['action']) && $_POST['action'] === 'logout') {
            logout();
            exit;
        }

        if (isset($_POST['action']) && $_POST['action'] === 'get-invitations') {

        }

        if (isset($_POST['action']) && $_POST['action'] === 'send-invitation' && isset($_POST['event_id']) && isset($_POST['invited_user_id'])) {
            $event_id = $_POST['event_id'];
            $invited_user_id = $_POST['invited_user_id'];
            $sender_user_id = getLoggedUser()['id'];

            createEventInvitation($event_id, $invited_user_id, getLoggedUser()['id']);

        }


        // ACEPTAR O RECHAZAR INVITACIÓN
        if (isset($_POST['action']) && $_POST['action'] === 'accept-invitation' && isset($_POST['event_id'])) {
            $event_id = $_POST['event_id'];
            $invited_user_id = getLoggedUser()['id'];
            
            if (checkIfUserIsInvitedToEvent($event_id, $invited_user_id)) {
                acceptEventInvitation($event_id, $invited_user_id);
            }
        }

        if (isset($_POST['action']) && $_POST['action'] === 'decline-invitation' && isset($_POST['event_id'])) {
            $event_id = $_POST['event_id'];
            $invited_user_id = getLoggedUser()['id'];
            
            if (checkIfUserIsInvitedToEvent($event_id, $invited_user_id)) {
                declineEventInvitation($event_id, $invited_user_id);
            }
        }
    }