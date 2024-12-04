<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    function getUserById($user_id) {
        global $db;
        
        $query = "SELECT * FROM users WHERE id = ?";
        $db->execute($query, [$user_id]);
        $user = $db->getData(DBConnector::FETCH_ROW);
        
        return $user;
    }

    function getUserIdByEmail($email) {
        global $db;
        
        $query = "SELECT id FROM users WHERE email = ?";
        $db->execute($query, [$email]);
        $user_id = $db->getData(DBConnector::FETCH_COLUMN);
        
        return $user_id;
    }

    function changePassword($user_id, $new_password) {
        global $db;

        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE users SET password = ? WHERE id = ?";
        $db->execute($query, [$new_hashed_password, $user_id]);
        
        return $db->getExecuted();
    }

    function resetPasswordWithToken($token, $new_password) {
        global $db;

        $user_id = getUserIdByToken($token);

        if (!$user_id) {
            return false;
        }
        
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE users SET password = ? WHERE id = ?";
        $db->execute($query, [$new_hashed_password, $user_id]);
        
        return $db->getExecuted();
    }

    function checkIfUserExists($user_id){
        global $db;

        $queryUsers = "SELECT id FROM users WHERE id = :id";
        $queryUsersParams = [
            ':id' => $user_id
        ];

        $userExists = $db->execute($queryUsers, $queryUsersParams);

        if(empty($userExists)){
            return False;

        }else{
            return True;
        }

    }


    function checkUserOwnProfile($logged_user_id, $owner_id){
        //*Necesario en user_profile.php: comprueba si el ID del logged_user coincide con el ID del perfil visitado, 
        //*SOLO en caso positivo, muestra el botón de editar perfil. 
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
        //*Función para editar SOLO alias y bio. Para actualizar pfp -> files_controller: updatePfp()
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
