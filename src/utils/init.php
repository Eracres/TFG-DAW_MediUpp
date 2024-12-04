<?php

    require_once __DIR__ . '/global-variables.php';

    define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/');
    define('NOT_ROOT_DIR','/TFG-DAW_MediUpp/src/');
    define('COMPONENTS_DIR', ROOT_DIR . 'components/');
    define('CONTROLLERS_DIR', ROOT_DIR . 'controllers/');
    define('PAGES_DIR', ROOT_DIR . 'pages/');
    define('PARTIALS_DIR', ROOT_DIR . 'partials/');
    define('UTILS_DIR', ROOT_DIR . 'utils/');
    
    define('CONTROLLERS_PATH', dirname(__DIR__) . '/controllers/');
    // Autoload para cargar automáticamente los controladores
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(CONTROLLERS_PATH)) as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            require_once $file->getPathname();
        }
    }

    define('DB_CLASS_PATH', dirname(__FILE__) . '/db/');
    // Autoload para cargar automáticamente la clase de base de datos
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