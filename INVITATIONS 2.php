<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';


function getInvitableUsers($event_id)
{
    //*Conseguir TODOS los usuarios que NO estén el evento
    //! MOVER FUNCION a invitation_controller ------------------------------------------
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

//TODO Probar si nos conviene la generación del form o mejor crearlo en HTML
if (isset($_GET['event_id'])) {
    $event_id = intval($_GET['event_id']); // Sanitizamos el input
    $users = getInvitableUsers($event_id); // Obtenemos los usuarios

    if (!$users) {
        echo "<p>No hay usuarios disponibles para este evento.</p>";
    } else {
        ?>
        <form action="" method="POST">
        <input type="hidden" name="event_id" value="<?=htmlspecialchars($event_id)?>">

        <?php
            foreach ($users as $user) {

            ?>
            <div>
                <input type="checkbox" name="invited_user_ids[]" value="<?=htmlspecialchars($user['id'])?>" id="user_<?=htmlspecialchars($user['id'])?>">
                <label for="user_<?=htmlspecialchars($user['id'])?>"><?=htmlspecialchars($user['usern'])?></label>
            </div>
            <?php
        }
        ?>
                <button type="submit">Enviar invitaciones</button>
        </form>

            <?php
    }
} else {
    echo "<p>Error: ID del evento no proporcionado.</p>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invited_user_ids'], $_POST['event_id'])) {
    $event_id = $current_event_id;
    $invited_user_ids = $_POST['invited_user_ids']; // Recoge los IDs seleccionados como un array
    $sender_user_id = $logged_user_id; // Suponiendo que la sesión del usuario está activa

    if (!empty($invited_user_ids) && is_array($invited_user_ids)) {
        // Llamar a la función para procesar las invitaciones
        createEventInvitation($event_id, $sender_user_id, ...$invited_user_ids);

        echo "<p>Invitaciones enviadas correctamente.</p>";
    } else {
        echo "<p>Error: No se seleccionaron usuarios para invitar.</p>";
    }
} else {
    echo "<p>Error al procesar el formulario.</p>";
}
?>