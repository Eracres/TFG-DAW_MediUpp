<!-- footer.php -->
<?php
    $social_links = [
        'instagram' => '#',
        'youtube' => '#',
        'linkedin' => '#',
        'twitter' => '#',
        'github' => '#'
    ];
?>

<footer class="app-footer">
    <div class="app-footer-container">
        <!-- Contenedor principal del footer con flex y responsive -->
        <div class="app-footer-flextext flex flex-col md:flex-row gap-6 md:justify-between items-start md:items-center">
            <div>
                <h3 class="text-lg font-semibold">La plataforma dedicada a mejorar la gestión de eventos</h3>
                <span>© <?= date("Y"); ?> MediUpp. Todos los derechos reservados.</span>
                <span>
                    <a href="#" class="hover:underline">Política de privacidad</a> |
                    <a href="#" class="hover:underline">Términos de uso</a> |
                    <a href="#" class="hover:underline">Contacto</a>
                </span>
            </div>
            <div class="flex gap-3">
                <?php foreach ($social_links as $platform => $link): ?>
                    <a href="<?= $link ?>" class="app-footer-icons" target="_blank" aria-label="<?= ucfirst($platform) ?>">
                        <i class="fab fa-<?= $platform ?>"></i>
                    </a>
                <?php endforeach; ?>
            </div>
            <div>
                <h3 class="text-lg font-semibold">Suscríbete a nuestro boletín</h3>
                <form action="#" method="post" class="mt-2 flex flex-col md:flex-row gap-2">
                    <input type="email" placeholder="Correo electrónico" class="p-2 rounded w-full md:w-auto" required>
                    <button type="submit" class="bg-yellow-500 text-gray-900 p-2 rounded">Suscribirse</button>
                </form>
            </div>
        </div>
</footer>