<!-- user-event_card.php -->
<a href="user_event_view.php?event_id=<?= urlencode($event['id']) ?>">
    <div class="event-container">
        <h2 class="event-title"><?= htmlspecialchars($event['title']); ?></h2>
        <div>
            <?php if (!empty($event['type']) && isset(EVENT_TYPE[$event['type']])): ?>
                <span class="event-type"><?= htmlspecialchars(EVENT_TYPE[$event['type']]); ?></span>
            <?php endif; ?>
            <span class="event-duration">
                <?= htmlspecialchars(date('d/m/Y', strtotime($event['start_date']))); ?> -  
                <?= htmlspecialchars(date('d/m/Y', strtotime($event['end_date']))); ?>
            </span>
        </div>
    </div>
</a>