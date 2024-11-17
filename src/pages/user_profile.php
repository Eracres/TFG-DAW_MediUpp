<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    //&checkSession();

    //&$logged_user = $_SESSION['logged_user'];

    //&$title = "Perfil de @" . trim($logged_user['usern']);
    ob_start();

    //!Las siguientes líneas deben ser eliminadas en el push (o al menos en el MERGE)
    //!Son solo para comprobar el funcionamiento del fichero sin probar el flujo global (sin login). 
    $id_usuario = $_GET['id_usuario']; 


    //gettear id de usuario
    if(!isset($_GET['id_usuario']) || empty($_GET['id_usuario'])){
        die('Muelto'); //^CAMBIAR
    }


    //Select para mostrar antes de editar
    $queryDatos = "SELECT * FROM users WHERE id = :id";
    $queryDatosParams = [
        'id' => $id_usuario
    ];
    $db->execute($queryDatos,$queryDatosParams);
    $logged_user = $db->getData(DBConnector::FETCH_ROW); //& la variable se llama loggedUser para poder simular toda la lógica con ella
        //$datosActuales
    
    

    //Insertar datos
    






    $formEditable = False; //POR DEFECTO


    //^Función para cambiar el estado de los datos a editable.
    function hacerEditable(){
        global $formEditable;
        if($formEditable === False){
            $formEditable = True;
        }elseif($formEditable === True){
            $formEditable = False;
        }
        
        return $formEditable;
    }

    if (isset($_POST['editar'])) {
        hacerEditable();
        echo "click";
    }

?>
<!-- //TODO Samu: No tengo figma para fijarme, así que voy a implementar funcionalidades de editar perfil con el esquema visual inspirado en twitter -->
<!-- //* MENU -->
<div class="">
    <div class="">
        <button id="logout-btn">Cerrar sesión</button>
    </div>
</div>

<!-- //* 1: Perfil -->
<div class="">
    <?php
    //^Lógica para mostrar inputs para editar if $formEditable = True;
    if($formEditable === False):

    ?>
        <img src="<?=$logged_user['pfp']?>" alt="pfp">
        <h3>Form no editable-><?=$logged_user['nombre']?></h3>    <!--//! CAMBIAR POR ALIAS tanto aquí como en la BD -->
        <p><?=$logged_user['apellido']?></p>    <!--//! CAMBIAR POR BIOGRAFIA tanto aquí como en la BD -->
        <!-- //^FORM para transformar en editables los campos del perfil -->
        <form action="" method="POST">
            <input class="btn-editar" type="submit" value="Editar perfil" name="editar">
        </form>
    
    <?php
    elseif($formEditable === True):
    
    ?>
        <h3>Form EDITABLE -><?=$logged_user['nombre']?></h3>    <!--//! CAMBIAR POR ALIAS tanto aquí como en la BD -->

        <form action="" id="form-editar-perfil" method="POST">
            <!-- <input type="text" name="nombre-editado" value="<?=htmlspecialchars($logged_user['nombre'])?>"> -->
            <input type="text" name="nombre-editado" value="<?=htmlspecialchars($logged_user['nombre'])?>"> //*alias
            <?php printError($error_nombre_editado);?>
            
            <input type="text" name="apellido-editado" value="<?=htmlspecialchars($logged_user['apellido'])?>"> //*biografia
            <?php printError($error_apellido_editado);?>
            
            
            <input type="file" name="pfp-editado" value=""> //*alias
            <?php printError($error_pfp_editado);?>
        

        </form>
</div>

<?php
    endif;

    //& $content = ob_get_clean();
    //& include PARTIALS_DIR . 'layout.php';
