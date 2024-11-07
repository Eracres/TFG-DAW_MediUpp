<?php

    require_once '../../utils/init.php';

    function getUserById($user_id) {
        global $db;
        
        $query = "SELECT * FROM users WHERE id = ?";
        $db->execute($query, [$user_id]);
        $user = $db->getData(DBConnector::FETCH_ROW);
        
        return $user;
    }



    function getEventsCreatedByUser(){
        //funcion para mostrar los eventos en 'Eventos Creados' de la user_profile en los que el usuario es ADMIN (aunque no lo haya creado) 

        global $db;
        $query = "
            SELECT * FROM 
        ";


    }