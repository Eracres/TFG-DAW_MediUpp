<?php
$socialLinks = [
    'instagram' => '#',
    'youtube' => '#',
    'linkedin' => '#',
    'twitter' => '#',
    'github' => '#'
];
?>

<footer class="app-footer">
    <!-- Contenedor principal del footer con flex y responsive -->
    <div class="app-footer-flextext">
        
        <!-- Información básica sobre MediUpp -->
        <div>
            <h3>Sobre MediUpp</h3>
            <p>MediUpp es una plataforma dedicada a mejorar la gestión de eventos.</p>
        </div>

        <!-- Redes sociales con íconos -->
        <div class="app-footer-socials">
            <?php foreach ($socialLinks as $platform => $link): ?>
                <a href="<?= $link ?>" class="app-footer-icon" target="_blank" aria-label="<?= ucfirst($platform) ?>">
                    <i class="fab fa-<?= $platform ?>"></i>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Boletín de Noticias -->
        <div>
            <h3>Suscríbete a nuestro boletín</h3>
            <form action="#" method="post" class="app-footer-form">
                <input type="email" placeholder="Correo electrónico" class="app-footer-input" required>
                <button type="submit" class="app-footer-button">Suscribirse</button>
            </form>
        </div>
    </div>

    <!-- Sección inferior con enlaces legales y derechos de autor -->
    <div class="app-footer-copyright">
        <p>© <?= date("Y"); ?> MediUpp. Todos los derechos reservados.</p>
        <p>
            <a href="#" class="app-footer-links">Política de Privacidad</a> |
            <a href="#" class="app-footer-links">Términos de Uso</a> |
            <a href="#" class="app-footer-links">Contacto</a>
        </p>
    </div>
</footer>
