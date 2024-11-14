<!-- user_event_view.php -->
<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    checkSession();

    $current_event_id = urldecode((int)$_GET['event_id']);
    $logged_user = $_SESSION['logged_user'];
    $logged_user_id = $logged_user['id'];
    
    if (!canUserAccessEvent($current_event_id, $logged_user_id)) {
        header('Location: user_event_list.php');
        exit;
    }

    $event_data = getEventData($current_event_id);
    $participants = getEventParticipants($current_event_id);
    $admins = getEventAdmins($current_event_id);

    $isAdmin = checkIfAdmin($logged_user_id, $current_event_id);
    if ($isAdmin) {
        $isCreatorOrSuperAdmin = checkIfCreatorOrSuperAdmin($logged_user_id, $current_event_id);
    }

    $title = trim($event_data['title']);
    ob_start();
?>

<div class="">
    <div class="">
        <div class="">
            <button id="">
                <i class="fa-solid fa-house"></i>
            </button>
        </div>
        <div class="">
            <h1 class=""> <?= htmlspecialchars($title); ?> </h1>
        </div>
    </div>
    <div class="">
        <section class="event-info">
            <div class="event-details">
                <div class="">
                    <h3 class=""> Detalles del evento </h3>
                </div>
                <div class="">
                    <div class="event-field event-title">
                        <span id="event-title"><?= htmlspecialchars($event_data['title']); ?></span>
                        <?php if ($isAdmin): ?>
                            <button class="edit-btn" data-field="title">E</button>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($event_data['type'])): ?>
                        <div class="event-field event-type">
                            <span id="event-type"><?= EVENT_TYPE[$event_data['type']]; ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="event-field event-location">
                        <span id="event-location"><?= htmlspecialchars($event_data['location']); ?></span>
                        <?php if ($isAdmin): ?>
                            <button class="edit-btn" data-field="location">E</button>
                        <?php endif; ?>
                    </div>
                    <div class="event-date event-field">
                        <span id="event-date"><?= htmlspecialchars($event_data['created_at']); ?></span>
                    </div>
                </div>
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
                                        <span class="participant-name"> 
                                            <?php if ($participant['id'] == $logged_user_id): ?>
                                                Tú
                                            <?php else: ?>
                                                <?= htmlspecialchars(trim($participant['usern'])); ?>
                                            <?php endif; ?> 
                                        </span>
                                        <?php if (in_array($participant['id'], $admins)): ?>
                                            <div>
                                                <span class="participant-admin"> <em> Administrador </em> </span>
                                            </div>
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
                    <div class="">
                        <button class="event-left-button"> 
                            <span> Salir del evento </span> 
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </div>
                    <?php if (isset($isCreatorOrSuperAdmin) && $isCreatorOrSuperAdmin): ?>
                        <div class="">
                            <button class="event-delete-button"> 
                                <span> Eliminar evento </span>
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <section class="event-content">

        </section>
    </div>
</div>

<?php
    $additional_scripts = ['js/event-view_script.js'];
    $content = ob_get_clean();

    include PARTIALS_DIR . 'layout.php';