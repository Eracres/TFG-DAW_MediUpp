<!-- user_event_list.php -->
<?php

    require_once '../utils/init.php';

    checkSession();

    $logged_user_id = $_SESSION['logged_user']['id'];

    $user_events = getUserEvents($logged_user_id);
    $public_events = getPublicEvents();

    $title = "Lista de eventos";
    ob_start();
?>

<div class="">
    <?php include 'components/add-event_modal.php'; ?>

</div>

<?php
    $content = ob_get_clean();
    include 'layout.php';