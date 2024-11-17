<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    function getEventPosts($event_id) {
        global $db;

        $query = "SELECT * FROM posts WHERE event_id = ?";
        $db->execute($query, [$event_id]);
        $posts = $db->getData(DBConnector::FETCH_ROW);

        return $posts;
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

        $query = "SELECT * FROM chats WHERE event_id = ?";
        $db->execute($query, [$event_id]);
        $messages = $db->getData(DBConnector::FETCH_ALL);

        return $messages;
    }
