<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

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

    function getPublicEvents() {
        global $db;
        // Obtemos el ID del usuario que está logueado
        $user_id = getLoggedUser()['id'];
    
        $query = "SELECT e.*, 
                    IF(ue.event_id IS NULL, 0, 1) AS is_joined
                FROM events e
                LEFT JOIN user_events ue ON e.id = ue.event_id AND ue.user_id = ?
                WHERE e.is_public = ?
                ORDER BY is_joined ASC, e.created_at DESC
                ";
    
        $db->execute($query, [$user_id, TRUE_VALUE]);
        $public_events = $db->getData(DBConnector::FETCH_ALL);
    
        return $public_events;
    }

    // Crea un nuevo evento y asigna al usuario como administrador y participante al mismo tiempo
    function createNewEvent($event_data, $user_id) {
        global $db;

        $query = "INSERT INTO events (title, description, type, location, start_date, end_date, created_by, is_public) VALUES (?, ?, ?, ?, ?)";
        $db->execute($query, [
            $event_data['title'],
            $event_data['description'],
            $event_data['type'],
            $event_data['location'],
            $event_data['start_date'],
            $event_data['end_date'],
            $user_id,
            $event_data['is_public']
        ]);
        // Obtener el ID del evento recien creado
        $new_event_id = $db->getLastInsertId();
        // Añadir al usuario como administrador y participante del evento
        $query = "INSERT INTO user_events (user_id, event_id, is_admin) VALUES (?, ?, ?)";
        $db->execute($query, [$user_id, $new_event_id, TRUE_VALUE]);

        return $db->getExecuted();
    }