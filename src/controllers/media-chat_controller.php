<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    function getEventMediaPosts($event_id) {
        global $db;

        $query = "SELECT * FROM posts WHERE event_id = ? ORDER BY created_at DESC";
        $db->execute($query, [$event_id]);
        $posts = $db->getData(DBConnector::FETCH_ROW);

        return $posts ? $posts : [];
    }

    // Obtener las reacciones de un post
    function getPostReactions($post_id) {
        global $db;
    
        $query = "SELECT reactions FROM posts WHERE id = ?";
        $db->execute($query, [$post_id]);
        $post = $db->getData(DBConnector::FETCH_COLUMN);
    
        return $post['reactions'] ? json_decode($post['reactions'], true) : [];
    }

    // Añadir o actualizar reacción de un post
    function addOrUpdatePostReaction($post_id, $user_id, $reaction) {
        global $db;
    
        $query = "SELECT reactions FROM posts WHERE id = ?";
        $db->execute($query, [$post_id]);
        $post = $db->getData(DBConnector::FETCH_COLUMN);
    
        $reactions = $post['reactions'] ? json_decode($post['reactions'], true) : [];
    
        // Actualizar o añadir reacción
        $reactions[$user_id] = $reaction;
    
        // Guardar las reacciones actualizadas
        $query = "UPDATE posts SET reactions = ? WHERE id = ?";
        $db->execute($query, [json_encode($reactions), $post_id]);
    
        return $db->getExecuted();
    }

    function removePostReaction($post_id, $user_id) {
        global $db;
    
        // Obtener las reacciones actuales
        $query = "SELECT reactions FROM posts WHERE id = ?";
        $db->execute($query, [$post_id]);
        $reactions = $db->getData(DBConnector::FETCH_COLUMN);
    
        // Decodificar JSON de las reacciones o inicializar como array vacío
        $reactions = $reactions ? json_decode($reactions, true) : [];
    
        // Eliminar la reacción del usuario si existe
        if (isset($reactions[$user_id])) {
            unset($reactions[$user_id]);
        }
    
        // Guardar las reacciones actualizadas
        $query = "UPDATE posts SET reactions = ? WHERE id = ?";
        $db->execute($query, [json_encode($reactions), $post_id]);
    
        return $db->getExecuted();
    }

    // Enviar mensaje
    function sendMessage($sender_id, $event_id, $message) {
        global $db;

        $query = "INSERT INTO chats (sender_id, event_id, message) VALUES (?, ?, ?)";
        $db->execute($query, [$sender_id, $event_id, $message]);
        // Cuando se inserta se actualiza al instante los mensajes del chat por AJAX
        return $db->getExecuted();
    }

    // Obtener mensajes del chat de un evento
    function getEventChatMessages($event_id) {
        global $db;

        $query = "SELECT * FROM chats WHERE event_id = ? ORDER BY created_at DESC";
        $db->execute($query, [$event_id]);
        $messages = $db->getData(DBConnector::FETCH_ALL);

        return $messages ? $messages : [];
    }
