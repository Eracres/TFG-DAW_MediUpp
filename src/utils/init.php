<?php

    require_once __DIR__ . '/global-variables.php';
    
    define('CONTROLLERS_PATH', dirname(__DIR__) . '/controllers/');
    // Autoload para cargar automáticamente los controladores
    foreach (glob(CONTROLLERS_PATH . '*.php') as $file) {
        require_once $file;
    }

    define('DB_CLASS_PATH', dirname(__FILE__) . 'db/');
    // Autoload para cargar automáticamente las clases desde el directorio de base de datos
    spl_autoload_register(function ($class) {
        require DB_CLASS_PATH . $class . '.php';
    });
    
    // Obtener una instancia única de la base de datos e inicializar la conexión
    $db = DBConnector::getInstance();
    $db->initialize(
        'tfg_mediupp_local',
        'malmorox',
        '1234'
    );

    session_start();