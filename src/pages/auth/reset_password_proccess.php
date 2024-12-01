<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    redirectIfLoggedIn();

    if (!isset($_GET['token'])) {
        header("Location: " . PAGES_DIR ."login.php");
        exit();
    } else {
        $token = htmlspecialchars($_GET['token']);

        if (!validateToken($token)) {
            $error = "Este enlace de restablecimiento de contraseña no es válido o ha caducado";
        } else {
            header("Location: " . PAGES_DIR ."auth/reset_password.php?token=$token");
            exit();
        }
    }