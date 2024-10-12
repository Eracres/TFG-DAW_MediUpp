<?php

require_once '../utils/init.php';

    function generateToken() {
        return bin2hex(openssl_random_pseudo_bytes(DEFAULT_TOKEN_CHARACTER_COUNT));
    }

    function getUserIdByToken($token) {
        global $db;
    
        $query = "SELECT user_id FROM tokens WHERE token = ? AND validity_date > NOW()";
        $db->execute($query, [$token]);
        $user_id = $db->getData(DBConnector::FETCH_COLUMN);
        
        if (empty($user_id)) {
            return null;
        }
        
        return $user_id;
    }

    

    

    function consumeToken($token) {
        global $db;
    
        $query = "UPDATE tokens SET consumed = ? WHERE token = ?";
        $db->execute($query, [TOKEN_CONSUMED_VALUE, $token]);
    }