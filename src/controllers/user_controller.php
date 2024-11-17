<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    function getUserById($user_id) {
        global $db;
        
        $query = "SELECT * FROM users WHERE id = ?";
        $db->execute($query, [$user_id]);
        $user = $db->getData(DBConnector::FETCH_ROW);
        
        return $user;
    }



    
    function checkUserOwnProfile(){
        if($logged_user['id'] === $id_usuario){
            $profile_owner = True;
        }
        
    }

    // //Funcion para printear errores
    // function printError($mensaje){
    //     echo '<p class="text-red-600" style="color:red">'.$mensaje.'</p>';
    // }