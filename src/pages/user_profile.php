<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    checkSession();

    $user_id = (int)urldecode($_GET['user_id']);
    $logged_user = $_SESSION['logged_user'];
    $logged_user_id = $_SESSION['logged_user']['id'];

    $owner = checkUserOwnProfile($logged_user_id, $user_id); //* FUNCIONA!! 


ob_start();


//Declaración de variables vacías para errores y aciertos
$update_exitoso = $error_update = $error_alias_edit = $error_bio_edit = $error_pfp_edit = "";




//gettear id de usuario
if (!isset($user_id) || empty($user_id)) {
    die("Este perfil de usuario no existe.
            <script>
                        setTimeout(function() {
                            window.location.href = 'login.php';
                        }, 2500);
                        </script>
        "); //^CAMBIAR
}


//Select para mostrar antes de editar

// Crear y ejecutar la consulta para obtener los datos del usuario
$queryDatos = "SELECT * FROM users WHERE id = :id";
$queryDatosParams = [
    ':id' => $user_id // Usamos el prefijo ':' en la clave para coincidir con los parámetros del query
];

// Ejecutar la consulta usando el DBConnector
$db = DBConnector::getInstance();
$db->execute($queryDatos, $queryDatosParams);

// Obtener los datos del usuario como una FILA asociativa
$datos_usuario = $db->getData(DBConnector::FETCH_ROW);


//Insertar datos editados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $edited_alias = $_POST['alias-edit'];
    $edited_bio = $_POST['bio-edit'];

    // Crear y ejecutar la consulta para obtener los datos del usuario
    $queryActualizar = "UPDATE users SET alias = :alias, bio = :bio WHERE id = :id";
    $queryActualizarParams = [
        ':alias' => $edited_alias,
        ':bio' => $edited_bio,
        ':id' => $user_id
    ];

    $db = DBConnector::getInstance();
    $db->execute($queryActualizar, $queryActualizarParams);
    $datos_actualizados = $db->getExecuted();

//*Espacio para llamar a la funcion de actualizar pfp

    updatePfp();
    

    if ($datos_actualizados) {
        $update_exitoso = "Cambios guardados correctamente.";
        $datos_usuario = $db->getData(DBConnector::FETCH_ROW); // Volver a cargar los datos del usuario
    } else {
        die('Algo ha salido mal.');
    }
}


$title = "Perfil de @" . trim($datos_usuario['usern']);


?>
<!-- //* 1: Perfil editable (IZQUIERDA)-->
<div class="">
    <div class="datos-perfil">
        <img src="<?= $datos_usuario['pfp_src'] ?>" alt="pfp">
        <h3><?= $datos_usuario['alias'] ?></h3>
        <p><?= $datos_usuario['bio'] ?></p>
    </div>

    <?php
    if ($owner === True):

    // ^BUTTON para transformar en editables los campos del perfil
    //^Este formulario solo es visible para el dueño del perfil. 
    ?>
        <button id="btn-editar" type="button">Editar perfil</button>
        <?php printSuccess($update_exitoso) ?>

        <!-- //^Formulario para editar los datos del perfil-->
        <div id="contenedor-editar-perfil" style="display: none;"> <!-- Ocultarlo inicialmente -->
            <h3>Actualiza tus datos</h3>
            <form action="" id="form-editar-perfil" method="POST" enctype="multipart/form-data">
                <label for="alias-edit">Alias:</label>
                <input type="text" name="alias-edit" value="<?= htmlspecialchars($datos_usuario['alias']) ?>">
                <?php printError($error_alias_edit); ?>

                <label for="bio-edit">Algo sobre ti:</label>
                <input type="text" name="bio-edit" value="<?= htmlspecialchars($datos_usuario['bio']) ?>">
                <?php printError($error_bio_edit); ?>

                <input type="file" name="pfp-edit[]" id="pfp-edit" value=""> //*pfp
                <?php printError($error_pfp_edit); ?>

                <!-- <input type="hidden" value="<?= $logged_user['id'] ?>" name="id-for-edit"> -->
                <input type="submit" value="Guardar cambios">

            </form>
        </div>

</div>
<!-- //^JS -->

<script>
    //^Función para mostrar el form de editar perfil
    document.addEventListener("DOMContentLoaded", function() {
        const btn_editar = document.getElementById("btn-editar");
        const contenedor_editar_perfil = document.getElementById("contenedor-editar-perfil");

        btn_editar.addEventListener("click", function() {
            contenedor_editar_perfil.style.display = "flex"; //Cambiar el display en diseño si es necesario. DEFAULT:none
        });
    });
</script>




<?php
    endif;
    $content = ob_get_clean();
    
    include PARTIALS_DIR . 'layout.php';