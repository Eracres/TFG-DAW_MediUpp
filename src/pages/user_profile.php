<!-- user_profile.php -->
<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    checkSession();

    $logged_user = $_SESSION['logged_user'];

    $title = "Perfil de @" . trim($logged_user['usern']);
    ob_start();
?>

<div class="">
    <div class="">
        <button id="logout-btn">Cerrar sesión</button>
    </div>
</div>

<?php
    $content = ob_get_clean();
    include PARTIALS_DIR . 'layout.php';