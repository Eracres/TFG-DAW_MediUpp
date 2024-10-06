<!-- layout.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= $title ?? 'MediUpp TFG'; ?> </title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="">
        <?= $content; ?>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>