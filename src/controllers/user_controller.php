<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    function getUserById($user_id) {
        global $db;
        
        $query = "SELECT * FROM users WHERE id = ?";
        $db->execute($query, [$user_id]);
        $user = $db->getData(DBConnector::FETCH_ROW);
        
        return $user;
    }

    function getUserIdByEmail($email) {
        global $db;
        
        $query = "SELECT id FROM users WHERE email = ?";
        $db->execute($query, [$email]);
        $user_id = $db->getData(DBConnector::FETCH_COLUMN);
        
        return $user_id;
    }

    function changePassword($user_id, $new_password) {
        global $db;

        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE users SET password = ? WHERE id = ?";
        $db->execute($query, [$new_hashed_password, $user_id]);
        
        return $db->getExecuted();
    }

    function resetPasswordWithToken($token, $new_password) {
        global $db;

        $user_id = getUserIdByToken($token);

        if (!$user_id) {
            return false;
        }
        
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE users SET password = ? WHERE id = ?";
        $db->execute($query, [$new_hashed_password, $user_id]);
        
        return $db->getExecuted();
    }