<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

function createEventInvitation($event_id, $sender_user_id, ...$invited_user_id)
{
    global $db;
    //*Si la cantidad de usuarios seleccionados es mayor a 1, lo recibe como array
    if (is_array($invited_user_id)) {
        foreach ($invited_user_id as $invited) {
            if (empty($invited_user_id) || $invited_user_id === null || checkIfUserExists($invited_user_id) != True) {
                echo "<script>
                alert('Uno o varios de los usuarios seleccionados no está(n) disponible(s) para invitar.')
                </script>";
            } elseif ($invited_user_id === $sender_user_id) {
                echo "<script>
                alert('No puedes invitarte a ti mismo al evento.')
                </script>";
            } else {
                $queryInvitation = "INSERT INTO invitations (event_id, invited_user_id, sender_user_id) 
                                        VALUES (:event_id, :invited_user_id, :sender_user_id)";

                $queryInvitationParams = [
                    ':event_id' => $event_id,
                    ':invited_user_id' => $invited,
                    ':sender_id' => $sender_user_id
                ];
            }
            
            $db->execute($queryInvitation, $queryInvitationParams);
        }
    } elseif (empty($invited_user_id) || $invited_user_id === null || checkIfUserExists($invited_user_id) != True) {
        echo "<script>
            alert('Uno o varios de los usuarios seleccionados no está(n) disponible(s) para invitar.')
            </script>";
    } elseif ($invited_user_id === $sender_user_id) {
        echo "<script>
        alert('No puedes invitarte a ti mismo al evento.')
        </script>";
    } else {
        $queryInvitation = "INSERT INTO invitations (event_id, invited_user_id, sender_user_id) 
                                    VALUES (:event_id, :invited_user_id, :sender_user_id)";

        $queryInvitationParams = [
            ':event_id' => $event_id,
            ':invited_user_id' => $invited_user_id,
            ':sender_id' => $sender_user_id
        ];

        $db->execute($queryInvitation, $queryInvitationParams);
    }
}


function getInvitableUsers($event_id)
{
    //*Conseguir TODOS los usuarios que NO estén el evento
    global $db;

        $queryInvitables = "
    SELECT u.id, u.usern
    FROM users u
    LEFT JOIN user_events ue ON u.id = ue.user_id AND ue.event_id = :event_id
    WHERE ue.user_id IS NULL
    ";

    $queryInvitablesParams = [':event_id' => $event_id];
    return $db->execute($queryInvitables, $queryInvitablesParams);
}




function getUserInvitations($user_id)
{
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

function checkIfUserIsInvitedToEvent($event_id, $invited_user_id)
{
    global $db;

    $query = "SELECT id FROM invitations WHERE event_id = ? AND invited_user_id = ? AND status = ?";
    $db->execute($query, [$event_id, $invited_user_id, INVITATION_STATUS['pending']]);

    $pending_invitation = $db->getData(DBConnector::FETCH_COLUMN);

    if ($pending_invitation) {
        return true;
    }

    return false;
}


function acceptEventInvitation($invitation_id, $invited_user_id)
{
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

function declineEventInvitation($invitation_id, $invited_user_id)
{
    global $db;

    $query = "UPDATE invitations SET status = ? WHERE id = ? AND invited_user_id = ?";
    $db->execute($query, [INVITATION_STATUS['declined'], $invitation_id, $invited_user_id]);

    return $db->getExecuted();
}

function deleteEventInvitation($event_id, $invited_user_id)
{
    global $db;

    $query = "DELETE FROM invitations WHERE event_id = ? AND invited_user_id = ?";
    $db->execute($query, [$event_id, $invited_user_id]);
}
