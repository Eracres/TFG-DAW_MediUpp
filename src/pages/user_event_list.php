<!-- user_event_list.php -->
<?php
    $title = "Lista de eventos";
    ob_start();
?>

<div class="">


</div>

<?php
    include 'components/add-event_modal.php';
    $content = ob_get_clean();
    include 'layout.php';