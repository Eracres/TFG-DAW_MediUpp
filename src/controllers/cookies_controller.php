<?php

    require_once '../../utils/init.php';

    // Función para destruir una cookie
    function destroyCookie($cookie_name) {
        unset($_COOKIE[$cookie_name]);
        setcookie($cookie_name, '', time() + COOKIE_EXPIRATION_TIME, '/');
    }

    // Función para verificar si hay una sesión iniciada y si no, verificar la cookie 'recuerdame' para setear la sesión
    function checkRememberMeCookie() {
        if (!isset($_SESSION['logged_user'])) {
            // Si no hay sesión iniciada verificamos la cookie 'recuerdame'
            if (isset($_COOKIE[COOKIE_REMEMBER_ME_NAME])) {
                $cookie_value = $_COOKIE[COOKIE_REMEMBER_ME_NAME];
                // El valor de la cookie 'recuerdame' es el token
                $user_id = getUserIdByToken($cookie_value);
                
                if ($user_id !== null) {
                    $_SESSION['logged_user'] = getUserById($user_id);
                }
            }
        }
    }