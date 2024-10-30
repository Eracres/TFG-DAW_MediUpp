<?php

    require_once '../../utils/init.php';

    function getEventData($event_id) {
        global $db;
    
        $query = "SELECT * FROM events WHERE id = ?";
        $db->execute($query, [$event_id]);
        $event_data = $db->getData(DBConnector::FETCH_ROW);
    
        return $event_data;
    }

    function checkIfAdmin($event_id, $user_id) {
        global $db;
    
        $query = "SELECT COUNT(*) 
                FROM event_admins 
                WHERE event_id = ? AND user_id = ?";
        $db->execute($query, [$event_id, $user_id]);
        // Devuelve true si es admin
        return $db->getData(DBConnector::FETCH_COLUMN) > 0;
    }

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

    function getEventAdmins($event_id) {
        global $db;
    
        $query = "SELECT u.id, u.first_name, u.last_name, u.email
                FROM users u
                INNER JOIN user_events ue ON u.id = ue.user_id
                WHERE ue.event_id = ? AND ue.is_admin = 1";
        $db->execute($query, [$event_id]); 
        $event_admins = $db->getData(DBConnector::FETCH_ALL);
    
        return $event_admins;
    }

    function assignAdminUser($event_id, $user_id) {
        global $db;
        
    }

    function leftEvent($event_id, $user_id, $is_admin = false) {
        global $db;
        
    }