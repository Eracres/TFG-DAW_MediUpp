<?php

    require_once '../../utils/init.php';

    function login($username, $password) {
        global $db;

        $query = "SELECT * FROM users WHERE username = ?";
        $db->execute($query, [$username]);
        $user = $db->getData(DBConnector::FETCH_ROW);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['logged_user'] = $user;

            return true;
        }

        return false;
    }