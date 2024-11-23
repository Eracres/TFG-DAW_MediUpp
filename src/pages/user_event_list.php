<!-- user_event_list.php -->
<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    checkSession();

    $logged_user = getLoggedUser();
    $logged_user_id = $logged_user['id'];

    $user_events = getUserEvents($logged_user_id);
    $public_events = getPublicEvents();

    $doc_title = "Lista de eventos";
    ob_start();
?>

<div class="">
    <div class="">
        <div class="">
            <div class="">
                <img src="<?= $logged_user['pfp_src']; ?>" alt="Foto de perfil de @<?= $logged_user['usern']; ?>">
            </div>
            <div>
                <span> <?= $logged_user['alias']; ?> </span>
                <span> @<?= $logged_user['usern']; ?> </span>
            </div>
        </div>
        <div class="">
            <div>
                <button id="open-modal-btn" data-action="add-event"> 
                    <i class="fa-solid fa-plus"></i> 
                    <span> Añadir evento </span>
                </button>
                <?php include COMPONENTS_DIR . 'add-event_modal.php'; ?>
            </div>
            <div class="">
                <a href="user_profile.php">
                    <button id="profile-btn" data-action="view-profile">
                        <i class="fa-solid fa-user"></i>
                        <span> Perfil </span>
                    </button>
                </a>
                <button class="logout-btn" data-action="logout">
                    <i class="fa-solid fa-door-open"></i>
                    <span> Cerrar sesión </span>
                </button>
            </div>
        </div>   
    </div>
    <div class="">
        <section class="">
            <?php if (!empty($user_events)): ?>
                <div class="">
                    <?php
                        foreach ($user_events as $event) {
                            include COMPONENTS_DIR . 'user-event_card.php';
                        }
                    ?>
                </div>
            <?php else: ?>
                <div class="">
                    <span class=""> No perteneces a ningún evento </span>
                </div>
            <?php endif; ?>
        </section>
        <section class="">
            <?php if (!empty($public_events)): ?>
                <div class="">
                    <?php
                        foreach ($public_events as $event) {
                            $event['is_disabled'] = ($event['is_joined'] == TRUE_VALUE);
                            include COMPONENTS_DIR . 'public-event_card.php';
                        }
                    ?>
                </div>
            <?php else: ?>
                <div class="">
                    <span class=""> No hay eventos disponibles </span>
                </div>
            <?php endif; ?>
        </section>
    </div>
</div>

<?php
    $additional_scripts = [
        '../assets/js/event-list_script.js', 
        '../assets/js/auth/script.js'
    ];
    $content = ob_get_clean();

    include PARTIALS_DIR . 'layout.php';