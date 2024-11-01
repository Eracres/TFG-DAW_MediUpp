<!-- user-event_card.php -->
<div class="event-card">
    <h2><?php echo htmlspecialchars($event['title']); ?></h2>
    <p><?php echo htmlspecialchars($event['type']); ?></p>
    <p>Date: <?php echo htmlspecialchars($event['created_at']); ?></p>
</div>