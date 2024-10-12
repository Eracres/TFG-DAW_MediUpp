<?php

    require_once '../../utils/init.php';

    function registerUser($user_data) {
        global $db;

        $hashed_password = password_hash($user_data['password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO users (first_name, last_name, username, password, email) VALUES (?, ?, ?, ?, ?)";
        $db->execute($query, [
            $user_data['first_name'],
            $user_data['last_name'],
            $user_data['username'],
            $hashed_password,
            $user_data['email']
        ]);

        // Retorna true si hace el insert y false si no lo hace
        return $db->getExecuted();
    }