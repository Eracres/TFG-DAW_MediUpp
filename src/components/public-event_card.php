<!-- public-event_card.php -->
<div class="event-container <?= $event['is_joined'] ? 'disabled' : ''; ?>">
    <div class="event-public-info">
        <h2 class="event-title"><?= htmlspecialchars($event['title']); ?></h2>
        <div class="row-2">
            <?php if (!empty($event['type']) && isset(EVENT_TYPE[$event['type']])): ?>
                <div class="event-type-cnt">
                    <span class="event-type"><?= htmlspecialchars(EVENT_TYPE[$event['type']]); ?></span>
                </div>
            <?php endif; ?>
            <div class="event-dates">
                <i class="fa-solid fa-clock"></i>
                <div class="event-duration">
                    <?php 
                        $start_date = strtotime($event['start_date']);
                        $end_date = strtotime($event['end_date']);
                    ?>
                    <div>
                        <span>Inicio:</span> 
                        <span><?= htmlspecialchars(date('d/m/Y H:i', $start_date)); ?></span>
                    </div>
                    <div>
                        <span>Fin:</span> 
                        <span><?= htmlspecialchars(date('d/m/Y H:i', $end_date)); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="event-actions">
    <?php if ($event['is_joined']): ?>
        <button class="event-join-btn" disabled>
            <i class="fa-solid fa-check"></i>
            <span> Ya te has unido </span>
        </button>
    <?php else: ?>
        <a href="user_event_view.php?event_id=<?= urlencode($event['id']) ?>">
            <button class="event-view-btn">
                <i class="fa-solid fa-eye"></i>
                <span> Ver evento </span>
            </button>
        </a>
    <?php endif; ?>
    </div>
</div>