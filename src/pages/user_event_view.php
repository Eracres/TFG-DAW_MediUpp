<!-- user_event_view.php -->
<?php

    $current_event_id = $_GET['event_id'];
    $logged_user_id = $_SESSION['logged_user']['id'];

    $isAdmin = checkIfAdmin($current_event_id, $logged_user_id);

    $title = "";
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
                            <div>
                                <div>
                                    <img src="" alt="">
                                </div>
                                <div>
                                    <span> <?= htmlspecialchars(trim($participant['first_name']) . ' ' . trim($participant['last_name'])); ?> </span>
                                    <?php if (in_array($participant['id'], $admins)): ?>
                                        <span> <em> Administrador </em> </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        
    </section>
    <section class="event-content">

    </section>
</div>

<?php
    $content = ob_get_clean();
    include 'layout.php';