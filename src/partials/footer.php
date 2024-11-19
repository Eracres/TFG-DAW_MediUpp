<!-- footer.php -->

<footer class="app-footer">
    <!-- Contenedor principal del footer con flex y responsive -->
    <div class="app-footer-flextext flex flex-col md:flex-row gap-6 md:justify-between items-start md:items-center">
        
        <!-- Información básica sobre MediUpp -->
        <div>
            <h3 class="text-lg font-semibold">Sobre MediUpp</h3>
            <p class="text-sm mt-2">MediUpp es una plataforma dedicada a mejorar la gestión de eventos y comunidades médicas.</p>
        </div>
        <!-- Redes sociales con íconos -->
        <div class="flex gap-3">
            <?php foreach ($socialLinks as $platform => $link): ?>
                <a href="<?= $link ?>" class="app-footer-icons" target="_blank" aria-label="<?= ucfirst($platform) ?>">
                    <i class="fab fa-<?= $platform ?>"></i>
                </a>
            <?php endforeach; ?>
        </div>
        <!-- Boletín de Noticias -->
        <div>
            <h3 class="text-lg font-semibold">Suscríbete a nuestro boletín</h3>
            <form action="#" method="post" class="mt-2 flex flex-col md:flex-row gap-2">
                <input type="email" placeholder="Correo electrónico" class="p-2 rounded w-full md:w-auto" required>
                <button type="submit" class="bg-yellow-500 text-gray-900 p-2 rounded">Suscribirse</button>
            </form>
        </div>
    </div>
    <!-- Sección inferior con enlaces legales y derechos de autor -->
    <div class="mt-6 text-center text-sm border-t border-gray-700 pt-4">
        <p>© <?= date("Y"); ?> MediUpp. Todos los derechos reservados.</p>
        <p>
            <a href="#" class="hover:underline">Política de Privacidad</a> |
            <a href="#" class="hover:underline">Términos de Uso</a> |
            <a href="#" class="hover:underline">Contacto</a>
        </p>
    </div>
</footer>
