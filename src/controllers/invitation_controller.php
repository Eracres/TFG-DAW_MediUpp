<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    function createEventInvitation($event_id, $invited_user_id, $sender_user_id) {
        global $db;

        /*if ($invited_user_id === $sender_user_id) {
            throw new Exception("No puedes invitarte a ti mismo");
        }*/

        $query = "INSERT INTO invitations (event_id, invited_user_id, sender_user_id, status) VALUES (?, ?, ?, ?)";
        $db->execute($query, [$event_id, $invited_user_id, $sender_user_id, INVITATION_STATUS['pending']]);
        
        return $db->getExecuted();
    }

    function getUserInvitations($user_id) {
        global $db;
        
        $query = "SELECT 
                    invitations.id,
                    invitations.status,
                    invitations.created_at,
                    invitations.updated_at,
                    events.title AS event_title,
                    users.usern AS sender_name
                FROM invitations 
                JOIN 
                    events ON invitations.event_id = events.id
                JOIN 
                    users ON invitations.sender_user_id = users.id
                WHERE 
                    invitations.invited_user_id = ?
                ORDER BY 
                    CASE 
                        WHEN invitations.status = ? THEN 0 
                        ELSE 1 
                    END,
                    invitations.updated_at DESC
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

    function acceptEventInvitation($invitation_id, $invited_user_id) {
        global $db;

        $query = "UPDATE invitations SET status = ? WHERE id = ? AND invited_user_id = ?";
        $db->execute($query, [INVITATION_STATUS['accepted'], $invitation_id, $invited_user_id]);
        
        if ($db->getExecuted()) {
            $query = "SELECT event_id FROM invitations WHERE id = ? AND invited_user_id = ?";
            $db->execute($query, [$invitation_id, $invited_user_id]);
            $event_id = $db->getData(DBConnector::FETCH_COLUMN);

            addUserToEvent($invited_user_id, $event_id);
        }
        
        return $db->getExecuted();
    }

    function declineEventInvitation($invitation_id, $invited_user_id) {
        global $db;

        $query = "UPDATE invitations SET status = ? WHERE id = ? AND invited_user_id = ?";
        $db->execute($query, [INVITATION_STATUS['declined'], $invitation_id, $invited_user_id]);
    
        return $db->getExecuted();
    }

    function deleteEventInvitation($event_id, $invited_user_id) {
        global $db;

        $query = "DELETE FROM invitations WHERE event_id = ? AND invited_user_id = ?";
        $db->execute($query, [$event_id, $invited_user_id]);
    }