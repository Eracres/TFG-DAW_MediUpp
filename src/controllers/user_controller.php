<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    function getUserById($user_id) {
        global $db;
        
        $query = "SELECT * FROM users WHERE id = ?";
        $db->execute($query, [$user_id]);
        $user = $db->getData(DBConnector::FETCH_ROW);
        
        return $user;
    }




    function checkUserOwnProfile($logged_user_id, $owner_id){
        /*//* Necesario en user_profile.php: comprueba si el ID del logged_user coincide con el ID del perfil visitado, 
        //*   SOLO en caso positivo, muestra el botón de editar perfil. 
        */
        $logged_user_id = (int)$logged_user_id;
        $owner_id = (int)$owner_id;

        if($logged_user_id === $owner_id){
            $profile_owner = True;
            
        }else{
            $profile_owner = False;
        }
        return $profile_owner;
    }


    function editProfileValues($user_id, $new_alias, $new_bio){
        //*Función para editar SOLO alias y bio (pfp más adelante)
        $queryUpdate = "UPDATE users 
                        SET alias = :alias, bio = :bio   
                        WHERE id = :id";
        $queryUpdateParams = [
            ':alias' => $new_alias,
            ':bio' => $new_bio,
            ':id'=>$user_id
        ];
        global $update_exitoso;
        global $error_update;

        global $db;
        $db->execute($queryUpdate, $queryUpdateParams);
        $datos_actualizados = $db->getExecuted();
        if($datos_actualizados){
            $update_exitoso = "Datos perfil actualizados.";
        }else{
            $error_update = "Los datos no han podido actualizarse.";
        }
    }

    // //Funcion para printear errores
    // function printError($mensaje){
    //     echo '<p class="text-red-600" style="color:red">'.$mensaje.'</p>';
    // }