<!-- add-participant_modal.php -->
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invited_user_ids'], $current_event_id)) {

    $logged_user_id = 4; //!BURRADA

    // $event_id = $current_event_id;
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




$current_event_id = 2; //!BURRADA

if (isset($current_event_id)) {
    $users = getInvitableUsers($current_event_id); // Obtenemos los usuarios

    if (!$users) {
        echo "<p style='color:red'>No hay usuarios disponibles para este evento.</p>";
    } else {
        ?>
        <form action="" method="POST">
        <input type="hidden" name="event_id" value="<?=htmlspecialchars($current_event_id)?>">

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
    echo "<p style='color:red'>Error: ID del evento no proporcionado.</p>";
}




?>