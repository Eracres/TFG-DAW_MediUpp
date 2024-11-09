<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Solicitud de logout por AJAX
        if (isset($_POST['action']) && $_POST['action'] === 'logout') {
            logout();
            exit;
        }
    }