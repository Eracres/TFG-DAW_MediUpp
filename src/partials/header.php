<!-- header.php -->
<header class="app-header">
    <div class="app-header-container">
        <!-- Logos -->
        <div class="app-header-logo">
            <img src="../resources/logo/logo.png" alt="MediUpp logo" class="app-header-logo-img">
        </div>
        <div class="app-header-title">
            <a href="user_event_list.php">
                <img src="../resources/logo/titulo.png" alt="MediUpp title" class="app-header-title-img">
            </a>
        </div>
        <!-- Notificaciones y botón de modo oscuro/claro -->
        <div class="app-header-controls">
            <button class="notification-button" aria-label="Notificaciones">
                <i class="fa-solid fa-inbox"></i>
                <span class="notification-counter" id="notification-counter"></span>
            </button>
            <?php include COMPONENTS_DIR . 'theme_switcher.php'; ?>
        </div>
    </div>
</header>