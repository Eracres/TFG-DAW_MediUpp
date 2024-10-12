<?php

    require_once '../utils/init.php';

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