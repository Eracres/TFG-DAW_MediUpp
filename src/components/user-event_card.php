<!-- user-event_card.php -->
<a href="user_event_view.php?event_id=<?= urlencode($event['id']) ?>">
    <div class="user-event-card">
        <h2><?= htmlspecialchars($event['title']); ?></h2>
        <p><?= htmlspecialchars(EVENT_TYPE[$event['type']]); ?></p>
        <p>Date: <?= htmlspecialchars($event['created_at']); ?></p>
    </div>
</a>