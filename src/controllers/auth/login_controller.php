<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    function login($username_or_email, $password) {
        global $db;

        $query = "SELECT * FROM users WHERE usern = ? OR email = ?";
        $db->execute($query, array_pad([], 2, $username_or_email));
        $user = $db->getData(DBConnector::FETCH_ROW);

        if ($user && password_verify($password, $user['passw'])) {
            $_SESSION['logged_user'] = $user;

            return true;
        }

        return false;
    }

    function logout() {
        ob_start();
        session_destroy();
        unset($_SESSION['logged_user']);
        //session_unset();
    
        if (isset($_COOKIE)) {
            $cookie_value = $_COOKIE[COOKIE_REMEMBER_ME_NAME];
            
            consumeToken($cookie_value);
            destroyCookie(COOKIE_REMEMBER_ME_NAME);
        }

        $response = [
            'success' => true,
            'message' => '¡Sesión cerrada con éxito!',
            'redirect' => '/tfg-daw_mediupp/src/pages/auth/login.php'
        ];
        ob_clean();
        echo json_encode($response);
        exit;
    }