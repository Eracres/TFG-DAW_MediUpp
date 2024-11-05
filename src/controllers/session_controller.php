<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    function checkSession() {
        // Verificamos si hay cookie de recordar sesión presente y iniciariamos la sesión en caso de que exista
        checkRememberMeCookie();
        // Si no hay una sesión iniciada en este punto redirigimos a la página de inicio de sesión
        if (!isset($_SESSION['logged_user'])) {
            header("Location: " . PAGES_DIR . "auth/login.php");
            exit();
        }
    }

    // Redirige fuera de una página si ya hay sesión iniciada
    function redirectIfLoggedIn() {
        if (isset($_SESSION['logged_user'])) {
            header("Location: ");
            exit();
        }
    }

    // Obtenemos el usuario que ha iniciado sesión como un array asociativo
    function getLoggedUser() {
        return $_SESSION['logged_user'];
    }