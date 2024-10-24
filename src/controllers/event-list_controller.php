<?php

    require_once '../utils/init.php';

    // Obtenemos todos los eventos que participa el usuario
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

    // Crea un nuevo evento y asigna al usuario como administrador y participante al mismo tiempo
    function createNewEvent($event_data, $user_id) {
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
        $query = "INSERT INTO user_events (user_id, event_id, is_admin) VALUES (?, ?, ?)";
        $db->execute($query, [$user_id, $new_event_id, TRUE_VALUE]);

        return $db->getExecuted();
    }