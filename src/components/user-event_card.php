<!-- user-event_card.php -->
<a href="user_event_view.php?event_id=<?= urlencode($event['id']) ?>">
    <div class="event-container">
        <h2><?= htmlspecialchars($event['title']); ?></h2>
        <?php if (!empty($event['type']) && isset(EVENT_TYPE[$event['type']])): ?>
            <p><?= htmlspecialchars(EVENT_TYPE[$event['type']]); ?></p>
        <?php endif; ?>
        <p><?= htmlspecialchars($event['created_at']); ?></p>
    </div>
</a>