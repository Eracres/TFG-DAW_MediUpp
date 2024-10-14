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

    function addNewEvent($event_data, $user_id) {
        global $db;

        $query = "INSERT INTO events (title, type, location, start_date, end_date) VALUES (?, ?, ?, ?, ?)";
        $db->execute($query, [
            $event_data['title'],
            $event_data['type'],
            $event_data['location'],
            $event_data['start_date'],
            $event_data['end_date']
        ]);

        // Obtener el ID del evento recien creado
        $new_event_id = $db->getLastInsertId();

        // Añadir al usuario como administrador y participante del evento
        $query = "INSERT INTO user_events (user_id, event_id) VALUES (?, ?)";
        $db->execute($query, [$user_id, $new_event_id]);

        $query = "INSERT INTO event_admins (event_id, user_id) VALUES (?, ?)";
        $db->execute($query, [$new_event_id, $user_id]);

        return $db->getExecuted();
    }