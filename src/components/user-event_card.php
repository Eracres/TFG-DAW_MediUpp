<!-- user-event_card.php -->
<a href="user_event_view.php?event_id=<?= urlencode($event['id']) ?>">
    <div class="event-container">
        <h2 class="event-title"><?= htmlspecialchars($event['title']); ?></h2>
        <div>
            <?php if (!empty($event['type']) && isset(EVENT_TYPE[$event['type']])): ?>
                <span class="event-type"><?= htmlspecialchars(EVENT_TYPE[$event['type']]); ?></span>
            <?php endif; ?>
            <span class="event-duration">
                <?php 
                    $start_date = strtotime($event['start_date']);
                    $end_date = strtotime($event['end_date']);
                    
                    if (date('Y-m-d', $start_date) === date('Y-m-d', $end_date)): ?>
                        <?= htmlspecialchars(date('d/m/Y', $start_date)); ?> 
                        (<?= htmlspecialchars(date('H:i', $start_date)); ?> - <?= htmlspecialchars(date('H:i', $end_date)); ?>)
                    <?php else: ?>
                        <?= htmlspecialchars(date('d/m/Y', $start_date)); ?> - <?= htmlspecialchars(date('d/m/Y', $end_date)); ?>
                    <?php endif; ?>
            </span>
        </div>
    </div>
</a>