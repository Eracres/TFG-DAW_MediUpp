<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    redirectIfLoggedIn();

    if (!isset($_GET['token'])) {
        header("Location: " . NOT_ROOT_DIR ."pages/auth/login.php");
        exit();
    } else {
        $token = htmlspecialchars($_GET['token']);

        if (!validateToken($token)) {
            $error = "Este enlace de restablecimiento de contraseña no es válido o ha caducado";
        } else {
            header("Location: " . NOT_ROOT_DIR ."pages/auth/reset_password.php?token=$token");
            exit();
        }
    }