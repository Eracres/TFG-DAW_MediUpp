<!-- controladores para el ejemplo //!ELIMINAR ANTES DE INTEGRAR -->
<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';
    // Mensaje de error inicial
    $error_message = "";

    // Procesar formulario si se envía
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subir-archivos'])) {
        insertPosts(); // Llamamos a la función definida en files_controller.php
    }
?>
<div class="files-modal-container">
    <div class="files-modal-content">
        <h1 class="modal-title">Subir Multimedia</h1>
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>
        <form action="" method="POST" enctype="multipart/form-data" class="modal-form">
            <label for="file-upload" class="modal-label">Comparte tu experiencia (Fotos/Vídeos):</label>
            <input type="file" name="file-upload[]" accept="image/*,video/*" multiple required class="modal-input">
            <input type="submit" name="subir-archivos" value="Subir archivos" class="modal-submit-btn">
        </form>
    </div>
</div>