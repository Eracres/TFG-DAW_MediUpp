<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    function createEventInvitation($event_id, $invited_user_id, $sender_user_id) {
        global $db;

        if ($invited_user_id === $sender_user_id) {
            throw new Exception("No puedes invitarte a ti mismo");
        }

        $query = "INSERT INTO invitations (event_id, invited_user_id, sender_user_id, status) VALUES (?, ?, ?, ?)";
        $db->execute($query, [$event_id, $invited_user_id, $sender_user_id, INVITATION_STATUS['pending']]);
        
        return $db->getExecuted();
    }

    function getUserInvitations($user_id) {
        global $db;
        
        $query = "SELECT * 
                FROM invitations 
                WHERE invited_user_id = ?
                ORDER BY 
                    CASE 
                        WHEN status = ? THEN 0 
                        ELSE 1 
                    END,
                    created_at DESC
                ";
        $db->execute($query, [$user_id, INVITATION_STATUS['pending']]);
        $invitations = $db->getData(DBConnector::FETCH_ALL);

        return $invitations;
    }

    function checkIfUserIsInvitedToEvent($event_id, $invited_user_id) {
        global $db;

        $query = "SELECT id FROM invitations WHERE event_id = ? AND invited_user_id = ? AND status = ?";
        $db->execute($query, [$event_id, $invited_user_id, INVITATION_STATUS['pending']]);
        
        $pending_invitation = $db->getData(DBConnector::FETCH_COLUMN);

        if ($pending_invitation) {
            return true;
        }

        return false;
    }

    function acceptEventInvitation($event_id, $invited_user_id) {
        global $db;

        $query = "UPDATE invitations SET status = ? WHERE event_id = ? AND invited_user_id = ?";
        $db->execute($query, [INVITATION_STATUS['accepted'], $event_id, $invited_user_id]);
        
        addUserToEvent($invited_user_id, $event_id);  
        
        return $db->getExecuted();
    }

    function declineEventInvitation($event_id, $invited_user_id) {
        global $db;

        $query = "UPDATE invitations SET status = ? WHERE event_id = ? AND invited_user_id = ?";
        $db->execute($query, [INVITATION_STATUS['declined'], $event_id, $invited_user_id]);
    }

    function deleteEventInvitation($event_id, $invited_user_id) {
        global $db;

        $query = "DELETE FROM invitations WHERE event_id = ? AND invited_user_id = ?";
        $db->execute($query, [$event_id, $invited_user_id]);
    }