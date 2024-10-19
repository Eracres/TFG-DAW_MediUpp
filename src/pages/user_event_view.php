<!-- user_event_view.php -->
<?php

    require_once '../utils/init.php';

    checkSession();

    $current_event_id = $_GET['event_id'];
    $logged_user_id = $_SESSION['logged_user']['id'];
    
    if (!canUserAccessEvent($logged_user_id, $current_event_id)) {
        header('Location: ');
        exit;
    }

    $event_data = getEventData($current_event_id);
    $participants = getEventParticipants($current_event_id);
    $admins = getEventAdmins($current_event_id);

    $isAdmin = checkIfAdmin($current_event_id, $logged_user_id);

    $title = $event_data['title'];
    ob_start();
?>

<div class="">
    <section class="event-info">
        <div class="event-details">
            

        </div>
        <div class="event-participants"> 
            <div class="">
                <h3 class=""> Participantes </h3>
            </div>
            <div class="event-participants-container">
                <ul class="event-participants-list">
                    <?php foreach ($participants as $participant): ?>
                        <li class="event-participant">
                            <div class="participant-container">
                                <div class="participant-col1">
                                    <div class="participant-pfp-container">
                                        <img src="" alt="" class="participant-pfp">
                                    </div>
                                </div>
                                <div class="participant-col2">
                                    <span class="participant-name"> <?= htmlspecialchars(trim($participant['first_name']) . ' ' . trim($participant['last_name'])); ?> </span>
                                    <?php if (in_array($participant['id'], $admins)): ?>
                                        <span class="participant-admin"> <em> Administrador </em> </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="event-user-controls">
            <div class="event-user-controls-container">
                <div>
                    <button class="event-left-button"> Salir del evento </button>
                </div>
                <?php if ($isAdmin): ?>
                    <div>
                        <button class="event-delete-button"> Eliminar evento </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <section class="event-content">

    </section>
</div>

<?php
    $content = ob_get_clean();
    include 'layout.php';