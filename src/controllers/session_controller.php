<?php

    require_once '../../utils/init.php';

    function checkSession() {
        // Verificamos si hay cookie de recordar sesión presente y iniciariamos la sesión en caso de que exista
        checkRememberMeCookie();
        // Si no hay una sesión iniciada en este punto redirigimos a la página de inicio de sesión
        if (!isset($_SESSION['logged_user'])) {
            header('Location: login.php');
            exit();
        }
    }