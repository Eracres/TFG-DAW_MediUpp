<!-- header.php -->
<header class="app-header">
    <div class="app-header-container">
        <!-- Logos -->
        <div class="app-header-logo">
            <img src="../../resources/logo/Logo(final).png" alt="Logo" class="app-header-logo-img">
        </div>
        <div class="app-header-title">
            <img src="../../resources/logo/Titulo(final).png" alt="Título" class="app-header-title-img">
        </div>
        <!-- Botón de modo oscuro/claro -->
        <div class="app-header-controls">
            <button class="notification-button app-header-modo" aria-label="Notifications">
                <i class="fa-solid fa-inbox"></i>
            </button>
            <?php include COMPONENTS_DIR . 'theme_switcher.php'; ?>
        </div>
    </div>
</header>