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

    // Obtiene los participantes del evento
    function getEventParticipants($event_id) {
        global $db;
    
        $query = "SELECT *
                FROM users u
                INNER JOIN user_events ue ON u.id = ue.user_id
                WHERE ue.event_id = ?";
        $db->execute($query, [$event_id]);
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

    // Remueve un usuario del evento
    function leftEvent($event_id, $user_id) {
        global $db;

        $query = "DELETE FROM user_events WHERE event_id = ? AND user_id = ?";
        $db->execute($query, [$event_id, $user_id]);

        $query = "SELECT COUNT(*) FROM user_events WHERE event_id = ?";
        $db->execute($queryMembers, [$event_id]);
        $remaining_members = $db->getData(DBConnector::FETCH_COLUMN);

        if (remaining_members == 0) {
            // Elimina el evento si no quedan miembros
            deleteEvent($event_id);
        } else {
            // Verifica si quedan administradores en el evento
            $query = "SELECT COUNT(*) FROM user_events WHERE event_id = ? AND is_admin = ?";
            $db->execute($queryAdmins, [$event_id, TRUE_VALUE]);
            $remaining_admins = $db->getData(DBConnector::FETCH_COLUMN);

            if ($remaining_admins == 0) {
                // Asigna como administrador al usuario que lleva más tiempo en el evento
                $newAdminId = getUserWithLongestJoinDate($event_id);
                if ($newAdminId) {
                    assignAdminUser($event_id, $newAdminId);
                }
            }
        }
    }