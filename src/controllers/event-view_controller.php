<?php

    require_once '../utils/init.php';

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
    }