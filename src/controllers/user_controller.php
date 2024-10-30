<?php

    require_once '../../utils/init.php';

    function getUserById($user_id) {
        global $db;
        
        $query = "SELECT * FROM users WHERE id = ?";
        $db->execute($query, [$user_id]);
        $user = $db->getData(DBConnector::FETCH_ROW);
        
        return $user;
    }