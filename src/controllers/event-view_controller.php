<?php

    require_once '../utils/init.php';

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