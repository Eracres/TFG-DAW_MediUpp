<?php

    require_once '../utils/init.php';

    function getUserEvents($user_id) {
        global $db;
    
        $query = "SELECT * 
                FROM events e
                INNER JOIN user_events ue ON e.id = ue.event_id
                WHERE ue.user_id = ?";
        $db->execute($query, [$user_id]);
        $user_events = $db->getData(DBConnector::FETCH_ALL);

        return $user_events;
    }

    function addNewEvent($event_data) {
        global $db;

        $query = "INSERT INTO events (title, type, location, start_date, end_date) VALUES (?, ?, ?, ?, ?)";
        $db->execute($query, [
            $event_data['title'],
            $event_data['type'],
            $event_data['location'],
            $event_data['start_date'],
            $event_data['end_date']
        ]);

        return $db->getExecuted();
    }