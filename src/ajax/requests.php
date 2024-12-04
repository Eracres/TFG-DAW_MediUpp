<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');

    // SOLICITUDES AJAX PARA EL FUNCIONAMIENTO DEL PROYECTO
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // CERRAR SESIÓN
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['action']) && $input['action'] === 'logout') {
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
        if (isset($input['action']) && $input['action'] === 'leave-event' && isset($input['event_id'])) {
            $event_id = (int)$input['event_id'];
            $user_id = getLoggedUser()['id'];

            try {
                deleteUserFromEvent($event_id, $user_id);
                $response = [
                    'success' => true,
                    'message' => '¡Has salido del evento exitosamente!',
                    'redirect' => '/tfg-daw_mediupp/src/pages/user_event_list.php'
                ];
            } catch (Exception $e) {
                $response = [
                    'success' => false,
                    'message' => 'Hubo un problema al salir del evento: ' . $e->getMessage()
                ];
            }

            echo json_encode($response);
            exit;
        }

        if (isset($input['action']) && $input['action'] === 'delete-event' && isset($input['event_id'])) {
            $event_id = (int)$input['event_id'];

            try {
                deleteEvent($event_id);
                $response = [
                    'success' => true,
                    'message' => '¡Evento eliminado exitosamente!',
                    'redirect' => '/tfg-daw_mediupp/src/pages/user_event_list.php'
                ];
            } catch (Exception $e) {
                $response = [
                    'success' => false,
                    'message' => 'Hubo un problema al eliminar el evento: ' . $e->getMessage()
                ];
            }

            echo json_encode($response);
            exit;
        }

        if (isset($input['action']) && $input['action'] === 'delete-participant' && isset($input['participant_id']) && isset($input['event_id'])) {
            $event_id = (int)$input['event_id'];
            $participant_id = (int)$input['participant_id'];

            try {
                deleteUserFromEvent($event_id, $participant_id);
                $response = [
                    'success'=> true,
                    'message'=> '¡Participante eliminado exitosamente!'
                ];
            } catch (Exception $e) {
                $response = [
                    'success'=> false,
                    'message'=> ''. $e->getMessage()
                ];  
            }
            echo json_encode($response);
            exit;
        }

        if (isset($input['action']) && $input['action'] === "assign-admin" && isset($input['participant_id']) && isset($input['event_id'])) {
            $event_id = (int)$input['event_id'];
            $participant_id = (int)$input['participant_id'];

            try {
                assignAdminUser($event_id, $participant_id);
                $response = [
                    'success'=> true,
                    'message'=> '¡Participante asignado como administrador exitosamente!'
                ];
            } catch (Exception $e) {
                $response = [
                    'success'=> false,
                    'message'=> 'f'. $e->getMessage()
                ];
            }
            echo json_encode($response);
            exit;
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