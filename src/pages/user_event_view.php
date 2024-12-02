<!-- user_event_view.php -->
<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    checkSession();

    $current_event_id = (int)urldecode($_GET['event_id']);
    $logged_user = getLoggedUser();
    $logged_user_id = $logged_user['id'];
    
    if (!canUserAccessEvent($current_event_id, $logged_user_id)) {
        header('Location: user_event_list.php');
        exit;
    }

    $isEventPublic = isEventPublic($current_event_id);
    $isUserInEvent = isUserInEvent($logged_user_id, $current_event_id);

    $event_data = getEventData($current_event_id);
    $participants = getEventParticipants($current_event_id);
    $admins = getEventAdmins($current_event_id);

    $isAdmin = checkIfAdmin($logged_user_id, $current_event_id);
    if ($isAdmin) {
        $isCreatorOrSuperAdmin = checkIfCreatorOrSuperAdmin($logged_user_id, $current_event_id);
    }

    $doc_title = trim($event_data['title']);
    ob_start();
?>

<div class="event-view-container">
    <div class="event-view-head">
        <div class="head-main">
            <div class="head-main-btn">
                <a href="user_event_list.php">
                    <button id="home-btn">
                        <i class="fa-solid fa-house"></i>
                    </button>
                </a>
            </div>
            <div class="head-main-title">
                <h1 class="event-name"> <?= htmlspecialchars($event_data['title']); ?> </h1>
            </div>
        </div>
        <div class="head-user-control">
            <button class="head-user-dropdow-btn">
                <div class="head-user-pfp">
                    <img src="<?= $logged_user['pfp_src'] ?>" alt="Foto de perfil de @<?= $logged_user['usern']; ?>">
                </div>
                <div class="head-user-uname">
                    <span> @<?= $logged_user['usern'] ?> </span>
                </div>
            </button>
            <div class="head-user-dropdown">
                <ul class="dropdown-list">
                    <a href="user_profile.php">
                        <li class="dropdown-element">
                            <i class="fa-solid fa-user"></i>
                            <span> Mi perfil </span>
                        </li>
                    </a>
                    <li class="dropdown-element">
                        <button class="logout-btn">
                            <i class="fa-solid fa-door-open"></i>
                            <span> Cerrar sesión </span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="event-view-content">
        <section class="event-info">
            <div class="event-details">
                <div class="detail-head-text">
                    <h3 class="head-text"> Detalles del evento </h3>
                </div>
                <div class="event-data-container">
                    <div class="event-field event-data-title">
                        <span id="event-title"><?= htmlspecialchars($event_data['title']); ?></span>
                        <?php if ($isAdmin): ?>
                            <button class="edit-btn" data-field="title"><i class="fa-solid fa-pen"></i></button>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($event_data['type']) && isset(EVENT_TYPE[$event_data['type']])): ?>
                        <div class="event-field event-data-type">
                            <span id="event-type"><?= EVENT_TYPE[$event_data['type']]; ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="event-field event-data-location">
                        <span id="event-location"><?= htmlspecialchars($event_data['location']); ?></span>
                        <?php if ($isAdmin): ?>
                            <button class="edit-btn" data-field="location"><i class="fa-solid fa-pen"></i></button>
                        <?php endif; ?>
                    </div>
                    <div class="event-field event-data-duration">
                        <span id="event-duration">
                        <?php 
                            $start_date = strtotime($event_data['start_date']);
                            $end_date = strtotime($event_data['end_date']);
                            
                            if (date('Y-m-d', $start_date) === date('Y-m-d', $end_date)): ?>
                                <?= htmlspecialchars(date('d/m/Y', $start_date)); ?> 
                                (<?= htmlspecialchars(date('H:i', $start_date)); ?> - <?= htmlspecialchars(date('H:i', $end_date)); ?>)
                            <?php else: ?>
                                <?= htmlspecialchars(date('d/m/Y', $start_date)); ?> - <?= htmlspecialchars(date('d/m/Y', $end_date)); ?>
                            <?php endif; ?>
                        </span>
                        </span>
                    </div>
                    <div class="event-field event-data-createddate">
                        <span id="event-date"><?= htmlspecialchars($event_data['created_at']); ?></span>
                    </div>
                </div>
            </div>
            <div class="event-participants"> 
                <div class="detail-head-text">
                    <h3 class="head-text"> Participantes </h3>
                </div>
                <div class="event-participants-container">
                    <?php if ($isAdmin): ?>
                        <div class="event-add-participant">
                            <button class="open-participant-modal-btn"> 
                                <i class="fa-solid fa-user-plus"></i> 
                                <span> Añadir participante </span>
                            </button>
                            <?php include COMPONENTS_DIR . 'add-participant_modal.php'; ?>
                        </div>
                    <?php endif; ?>
                    <ul class="event-participants-list">
                        <?php foreach ($participants as $participant): ?>
                            <?php $isParticipantAdmin = in_array($participant['id'], $admins); ?>
                            <li class="event-participant" data-participant-id="<?= $participant['id']; ?>">
                                <div class="participant-container">
                                    <div class="participant-col1">
                                        <div class="participant-pfp-container">
                                            <img src="<?= $participant['pfp_src'] ?>" alt="Foto de perfil de @<?= $participant['usern']; ?>" class="participant-pfp">
                                        </div>
                                    </div>
                                    <div class="participant-col2">
                                        <span class="participant-name"> 
                                            <?php if ($participant['id'] == $logged_user_id): ?>
                                                Tú
                                            <?php else: ?>
                                                @<?= htmlspecialchars(trim($participant['usern'])); ?>
                                            <?php endif; ?> 
                                        </span>
                                        <?php if ($isParticipantAdmin): ?>
                                            <div>
                                                <span class="participant-admin"> <em> Administrador </em> </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($participant['id'] != $logged_user_id): ?>
                                        <div class="participant-col3">
                                            <button class="participant-actions-btn">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <?php include COMPONENTS_DIR . 'event-participant_menu.php'; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="event-user-controls">
                <div class="event-user-controls-container">
                    <!-- Si el usuario no está en el evento, no mostrar el boton de salirse -->
                    <?php if ($isUserInEvent): ?>
                        <div class="control-left-event">
                            <button class="event-left-button"> 
                                <span> Salir del evento </span> 
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($isCreatorOrSuperAdmin) && $isCreatorOrSuperAdmin): ?>
                        <div class="control-delete-event">
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
            <div class="event-content-header">
                <button class="toggle-section-btn" data-target="media-section">
                    <i class="fa-solid fa-photo-film"></i> 
                    <span> Media </span>
                </button>
                <button class="toggle-section-btn" data-target="chat-section">
                    <i class="fa-solid fa-comments"></i>
                    <span> Chat </span>
                </button>
            </div>
            <div class="event-content-dynamic" id="dynamic-content">
                <div class="">
                    <!-- El contenido se cargará aquí -->
                    <div class="open-post-modal-btn">
                        <button id="create-post-btn" class="btn btn-primary">Crear Post</button>
                    </div>

                    <div class="chat-message-bar">
                        <form action="">
                            <input type="text" id="chat-message-input" placeholder="Escribe un mensaje..." />
                            <button id="send-message-btn" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php
    $additional_scripts = [
        '../assets/js/event-view_script.js', 
        '../assets/js/auth/script.js'
    ];
    $content = ob_get_clean();

    include PARTIALS_DIR . 'layout.php';