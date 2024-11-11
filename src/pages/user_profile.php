<!-- user_profile.php -->
<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    checkSession();

    $logged_user = $_SESSION['logged_user'];
    $logged_user_id = $logged_user['id'];

    $title = "Perfil de @" . trim($logged_user['usern']);
    ob_start();
?>
<!-- //TODO NOTA de Samu: Siguiendo esquema del FIGMA para 'Pagina de usuario 2.0', 3 contenedores (de izquierda a derecha): editar perfil, eventos creados, eventos públicos.   -->


<div class="">
    <div class="">
        <button id="logout-btn">Cerrar sesión</button>
    </div>
</div>

<div class="">

</div>

<?php
    $content = ob_get_clean();
    include PARTIALS_DIR . 'layout.php';
