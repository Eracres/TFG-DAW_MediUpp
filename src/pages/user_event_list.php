<!-- user_event_list.php -->
<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    checkSession();

    $logged_user_id = $_SESSION['logged_user']['id'];

    $user_events = getUserEvents($logged_user_id);
    $public_events = getPublicEvents();

    $title = "Lista de eventos";
    ob_start();
?>

<div class="">
    <?php include COMPONENTS_DIR . 'add-event_modal.php'; ?>
    <div class="">
        <div class="">

        </div>
    </div>
    <div class="">
        <section class="">
            <?php if (empty($user_events)): ?>
                <div class="">
                    <span class=""> No perteneces a ningún evento </span>
                </div>
            <?php else: ?>
                <div class="">
                    <?php
                        foreach ($user_events as $event) {
                            include COMPONENTS_DIR . 'user-event_card.php';
                        }
                    ?>
                </div>
            <?php endif; ?>
        </section>
        <section class="">
            <?php if (empty($public_events)): ?>
                <div class="">
                    <span class=""> No hay eventos disponibles </span>
                </div>
            <?php else: ?>
                <div class="">
                    <?php
                        foreach ($public_events as $event) {
                            include COMPONENTS_DIR . 'public-event_card.php';
                        }
                    ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</div>

<?php
    $content = ob_get_clean();
    include PARTIALS_DIR . 'layout.php';