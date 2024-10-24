<?php

    require_once '../../utils/init.php';

    function login($username_or_email, $password) {
        global $db;

        $query = "SELECT * FROM users WHERE usern = :identifier OR email = :identifier";
        $db->execute($query, [":identifier" => $username_or_email]);
        $user = $db->getData(DBConnector::FETCH_ROW);

        if ($user && password_verify($password, $user['passw'])) {
            $_SESSION['logged_user'] = $user;

            return true;
        }

        return false;
    }

    function logout() {
        session_destroy();
        unset($_SESSION['logged_user']);
        //session_unset();
    
        if (isset($_COOKIE)) {
            $cookie_value = $_COOKIE[COOKIE_REMEMBER_ME_NAME];
            
            consumeToken($cookie_value);
            destroyCookie(COOKIE_REMEMBER_ME_NAME);
        }

        header("location: login.php");
        exit;
    }