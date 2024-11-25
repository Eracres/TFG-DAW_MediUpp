<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    // Obtiene los datos del evento
    function getEventData($event_id) {
        global $db;
    
        $query = "SELECT * FROM events WHERE id = ?";
        $db->execute($query, [$event_id]);
        $event_data = $db->getData(DBConnector::FETCH_ROW);
    
        return $event_data;
    }

    // Verifica si el usuario es administrador del evento
    function checkIfAdmin($user_id, $event_id) {
        global $db;
    
        $query = "SELECT is_admin 
                FROM user_events 
                WHERE user_id = ? AND event_id = ?";
        $db->execute($query, [$user_id, $event_id]);
        // Devuelve true si es admin
        return $db->getData(DBConnector::FETCH_COLUMN) == TRUE_VALUE;
    }

    // Verifica si el usuario es creador o super administrador del evento
    function checkIfCreatorOrSuperAdmin($user_id, $event_id) {
        global $db;
    
        $query = "SELECT created_by FROM events WHERE id = ?";
        $db->execute($query, [$event_id]);
        $creator_id = $db->getData(DBConnector::FETCH_COLUMN);

        if ($creator_id == $user_id) {
            return true;
        }

        $admins = getEventAdmins($event_id);
        
        return !empty($admins) && $admins[0] == $user_id;
    }

    // Obtiene los participantes del evento
    function getEventParticipants($event_id) {
        global $db;

        $logged_user_id = getLoggedUser()['id'];
        $admins = getEventAdmins($event_id);
        // Primero el usuario logueado, luego los administradores y luego los demás
        $query = "SELECT u.*, 
                    CASE WHEN u.id = ? THEN 0 
                        WHEN u.id IN (?) THEN 1 
                        ELSE 2 
                    END AS participant_order
                FROM users u
                INNER JOIN user_events ue ON u.id = ue.user_id
                WHERE ue.event_id = ?
                ORDER BY participant_order, u.usern";
        $admins_str = implode(',', $admins);

        $db->execute($query, [$logged_user_id, $admins_str, $event_id]);
        $event_participants = $db->getData(DBConnector::FETCH_ALL);

        return $event_participants;
    }

    // Obtiene los administradores del evento
    function getEventAdmins($event_id) {
        global $db;
    
        $query = "SELECT u.id
                FROM users u
                INNER JOIN user_events ue ON u.id = ue.user_id
                WHERE ue.event_id = ? AND ue.is_admin = ?";
        $db->execute($query, [$event_id, TRUE_VALUE]); 
        $event_admins = $db->getData(DBConnector::FETCH_ALL);
    
        return array_column($event_admins, 'id');
    }

    // Asigna un usuario como administrador del evento (solo los admins del evento pueden hacerlo)
    function assignAdminUser($event_id, $user_id) {
        global $db;
        
        $query = "UPDATE user_events SET is_admin = ? WHERE event_id = ? AND user_id = ?";
        $db->execute($query, [TRUE_VALUE, $event_id, $user_id]);

        return $db->getExecuted();
    }

    // Elimina un usuario del evento
    function deleteUserFromEvent($event_id, $user_id) {
        global $db;

        $query = "DELETE FROM user_events WHERE event_id = ? AND user_id = ?";
        $db->execute($query, [$event_id, $user_id]);

        checkEventRemainingUsersAndAdmins($event_id);
    }