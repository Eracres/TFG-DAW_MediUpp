<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    function addUserToEvent($user_id, $event_id) {
        global $db;

        $query = "INSERT INTO user_events (user_id, event_id) VALUES (?, ?)";
        $db->execute($query, [$user_id, $event_id]);
    }

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

    function checkEventRemainingUsersAndAdmins($event_id) {
        global $db;
        
        $query = "SELECT COUNT(*) FROM user_events WHERE event_id = ?";
        $db->execute($query, [$event_id]);
        $remaining_members = $db->getData(DBConnector::FETCH_COLUMN);

        if ($remaining_members == 0) {
            // Elimina el evento si no quedan miembros
            deleteEvent($event_id);
        } else {
            // Verifica si quedan administradores en el evento
            $query = "SELECT COUNT(*) FROM user_events WHERE event_id = ? AND is_admin = ?";
            $db->execute($query, [$event_id, TRUE_VALUE]);
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

    function getUserWithLongestJoinDate($event_id) {
        global $db;
    
        $query = "SELECT user_id 
            FROM user_events 
            WHERE event_id = ? 
            ORDER BY join_date ASC 
            LIMIT 1";
        $db->execute($query, [$event_id]);
        // Devuelve el id del usuario que lleva más tiempo en el evento
        return $db->getData(DBConnector::FETCH_COLUMN);
    }

    function deleteEvent($event_id) {
        global $db;
        // Eliminar todas las filas en user_events relacionadas con el evento
        $query = "DELETE FROM user_events WHERE event_id = ?";
        $db->execute($query, [$event_id]);
        // Eliminar el evento
        $query = "DELETE FROM events WHERE id = ?";
        $db->execute($query, [$event_id]);

        return $db->getExecuted();
    }