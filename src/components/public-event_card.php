<!-- public-event_card.php -->
<div class="event-container">
    <h2><?php echo htmlspecialchars($event['title']); ?></h2>
    <p><?php echo htmlspecialchars(EVENT_TYPE[$event['type']]); ?></p>
    <p>Date: <?php echo htmlspecialchars($event['created_at']); ?></p>
    <a href="user_event_view.php?event_id=<?= urlencode($event['id']) ?>"> Ir </a>
</div>
