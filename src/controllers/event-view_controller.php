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
    function checkIfAdmin($event_id, $user_id) {
        global $db;
    
        $query = "SELECT COUNT(*) 
                FROM event_admins 
                WHERE event_id = ? AND user_id = ?";
        $db->execute($query, [$event_id, $user_id]);
        // Devuelve true si es admin
        return $db->getData(DBConnector::FETCH_COLUMN) > 0;
    }

    // Obtiene los participantes del evento
    function getEventParticipants($event_id) {
        global $db;
    
        $query = "SELECT u.id, u.first_name, u.last_name, u.email
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
                WHERE ue.event_id = ? AND ue.is_admin = 1";
        $db->execute($query, [$event_id]); 
        $event_admins = $db->getData(DBConnector::FETCH_ALL);
    
        return $event_admins;
    }

    // Asigna un usuario como administrador del evento (solo los admins del evento pueden hacerlo)
    function assignAdminUser($event_id, $user_id) {
        global $db;
        
        $query = "INSERT INTO event_admins (event_id, user_id) VALUES (?, ?)";
        $db->execute($query, [$event_id, $user_id]);

        return $db->getExecuted();
    }

    // Remueve un usuario del evento y si es admin, lo elimina de los admins del evento
    function leftEvent($event_id, $user_id, $is_admin = false) {
        global $db;
        
        $query = "DELETE FROM user_events WHERE event_id = ? AND user_id = ?";
        $db->execute($query, [$event_id, $user_id]);

        if ($is_admin) {
            $query = "DELETE FROM event_admins WHERE event_id = ? AND user_id = ?";
            $db->execute($query, [$event_id, $user_id]);
        }
    }