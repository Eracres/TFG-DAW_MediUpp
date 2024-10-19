<?php

    require_once '../utils/init.php';

    function canUserAccessEvent($event_id, $user_id) {
        global $db;

        // Obtener si el evento es público o privado
        $query = "SELECT is_public FROM events WHERE id = ?";
        $db->execute($query, [$event_id]);
        $is_public = $db->getData(DBConnector::FETCH_COLUMN);

        // Si el evento es público, permitir el acceso
        if ($is_public) {
            return true;
        }
        
        // Si el evento es privado, verificar si el usuario pertenece al evento
        $query = "SELECT COUNT(*) 
                FROM user_events 
                WHERE user_id = ? AND event_id = ?";
        $db->execute($query, [$user_id, $event_id]);
    
        // Si no es miembro del evento, devolver false
        return $db->getData(DBConnector::FETCH_COLUMN) > 0;
    }

    function deleteEvent($event_id) {
        global $db;
    
        $query = "DELETE FROM events WHERE id = ?";
        $db->execute($query, [$event_id]);
    }