<!-- event-participant_menu.php -->
<div class="event-participant-actions-menu">
    <ul class="menu-list">
        <li class="list-element">
            <a href="user_profile.php">
                <button class="menu-btn">
                    <i class="fa-solid fa-user"></i>
                    <span> Ver perfil </span>
                </button>
            </a>
        </li>
        <?php if ($isAdmin): ?>
            <?php 
                $canAssignAdmin = !$isParticipantAdmin;
                $canRemoveParticipant = $isCreatorOrSuperAdmin || !$isParticipantAdmin;
            ?>
            <li class="list-element">
                <button class="menu-btn assign-participant-admin-btn" <?= $canAssignAdmin ? '' : 'disabled'; ?>>
                    <i class="fa-solid fa-user-gear"></i>
                    <span> Asignar administrador </span>
                </button>
            </li>
            <li class="list-element">
                <button class="menu-btn delete-participant-btn" <?= $canRemoveParticipant ? '' : 'disabled'; ?>>
                    <i class="fa-solid fa-user-minus"></i>
                    <span> Eliminar participante </span>
                </button>
            </li>
        <?php endif; ?>
    </ul>
</div>