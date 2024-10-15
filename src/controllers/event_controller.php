<?php

    require_once '../utils/init.php';

    function deleteEvent($event_id) {
        global $db;
    
        $query = "DELETE FROM events WHERE id = ?";
        $db->execute($query, [$event_id]);
    }