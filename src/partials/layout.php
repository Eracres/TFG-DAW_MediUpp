<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= $doc_title . ' | MediUpp' ?? 'MediUpp TFG'; ?> </title>
    <meta name="description" content="MediUpp es una aplicación web para la organización de todo tipo de eventos">
    <meta name="author" content="Samuel Macias">
    <meta name="author" content="Sergio Cáceres">
    <meta name="author" content="Marcos Almorox">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="app-body">
        <?php include 'header.php'; ?>

        <main class="app-main">
            <?= $content; ?>
        </main>

        <?php include 'footer.php'; ?>
    </div>
    <script src="../assets/js/main_script.js"></script>
    <?php if (isset($additional_scripts) && is_array($additional_scripts)): ?>
        <?php foreach ($additional_scripts as $script_src): ?>
            <script src="<?= $script_src; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>