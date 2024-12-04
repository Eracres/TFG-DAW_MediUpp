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
<h1>Subir multimedia</h1>
<?php if (!empty($error_message)): ?>
    <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
<?php endif; ?>

<form action="" method="POST" enctype="multipart/form-data">

    <label for="file-upload">Comparte tu experiencia (Fotos/Vídeos):</label>
    <input type="file" name="file-upload[]" accept="image/*,video/*" multiple required>

    <input type="submit" name="subir-archivos" value="Subir archivos">
    <p> <?= $error_message ?> </p>
</form>