<?php
    // Obtener una instancia única de la base de datos e inicializar la conexión
    $db = DBConnector::getInstance();
    $db->initialize(
        'tfg_mediupp_local',
        'malmorox',
        '1234'
    );

    session_start();