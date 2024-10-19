<?php

    require_once '../utils/init.php';

    function generateToken() {
        return bin2hex(openssl_random_pseudo_bytes(DEFAULT_TOKEN_CHARACTER_COUNT));
    }

    // Obtener el ID de usuario a partir de un token
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

    function saveToken($token, $user_id, $save_type) {
        global $db;

        if ($save_type === 'remember_me') {
            $expiration_time = DEFAULT_REMEMBER_ME_TOKEN_EXPIRATION_TIME; // 7 días
        } elseif ($save_type === 'recovery_password') {
            $expiration_time = DEFAULT_RECOVERY_EMAIL_TOKEN_EXPIRATION_TIME; // 15 minutos
        } else {
            throw new Exception("Tipo de token no válido");
        }

        $expiration_date = date('Y-m-d H:i:s', time() + $expiration_time);
    
        $query = "INSERT INTO tokens (token, user_id, validity_date, consumed) VALUES (?, ?, ?, ?)";
        $db->execute($query, [$token, $user_id, $expiration_date, TOKEN_NOT_CONSUMED_VALUE]);
    }

    function validateToken($token) {
        global $db;
    
        $query = "SELECT * FROM tokens WHERE token = ? AND validity_date > NOW() AND consumed = ?";
        $db->execute($query, [$token, TOKEN_NOT_CONSUMED_VALUE]);
        $token = $db->getData(DBConnector::FETCH_ROW);
        
        return $token ? true : false;
    }

    function consumeToken($token) {
        global $db;
    
        $query = "UPDATE tokens SET consumed = ? WHERE token = ?";
        $db->execute($query, [TOKEN_CONSUMED_VALUE, $token]);
    }

    function deleteToken($token) {
        global $db;
    
        $query = "DELETE FROM tokens WHERE token = ?";
        $db->execute($query, [$token]);
    }