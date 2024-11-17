<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    function getUserById($user_id) {
        global $db;
        
        $query = "SELECT * FROM users WHERE id = ?";
        $db->execute($query, [$user_id]);
        $user = $db->getData(DBConnector::FETCH_ROW);
        
        return $user;
    }


    


    function getEventsCreatedByUser(){
        //funcion para mostrar los eventos en 'Eventos Creados' de la user_event_list en los que el usuario es ADMIN (aunque no lo haya creado) 

        global $db;
        $query = "
            SELECT * FROM 
        ";


    }

    //Funcion para printear errores
    function printError($mensaje){
        echo '<p class="text-red-600" style="color:red">'.$mensaje.'</p>';
    }