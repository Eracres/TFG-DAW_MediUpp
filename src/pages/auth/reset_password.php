<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    redirectIfLoggedIn();

    if (!isset($_GET['token']) || !validateToken($_GET['token'])) {
        header("Location: " . PAGES_DIR ."login.php");
        exit();
    } else {
        $token = htmlspecialchars($_GET['token']);
    }

    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
        $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : null;
        $new_password_confirm = isset($_POST['new_password_confirm']) ? trim($_POST['new_password_confirm']) : null;

        if (empty($new_password)) {
            $errors['new-password'] = "Debes introducir una nueva contraseña";
        } 

        if (empty($new_password_confirm)) {
            $errors['new-password-confirm'] = "Debes confirmar la nueva contraseña";
        } elseif (!empty($new_password) && !hash_equals($new_password, $new_password_confirm)) {
        //} elseif (!empty($new_password) && $new_password !== $new_password_confirm) {
            $errors['passwords-not-match'] = "Las contraseñas deben coincidir";
        }

        if (empty($errors)) {
            $success = resetPasswordWithToken($token, $new_password);

            if ($success) {
                header("Location: " . PAGES_DIR . "auth/login.php");
                exit();
            } else {
                $errors['reset_failed'] = "Error al restablecer la contraseña. Inténtalo de nuevo.";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Restablece tu contraseña | MediUpp </title>
    <meta name="description" content="MediUpp es una aplicación web para la organización de todo tipo de eventos">
    <meta name="author" content="Samuel Macias">
    <meta name="author" content="Sergio Cáceres">
    <meta name="author" content="Marcos Almorox">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2> Resetea tu contraseña </h2>
    <?php if (isset($exito)) : ?>
        <span class="exito"> <?= $exito ?> </span>
    <?php endif; ?>
    <?php if (isset($errores['general'])) : ?>
        <span class="error"> <?= $errores['general'] ?> </span>
    <?php endif; ?>
    <form action="<?= $_SERVER["REQUEST_URI"]; ?>" method="post">
        <label for="nueva_contrasena"> Nueva contraseña: </label> <br>
        <input type="password" name="nueva_contrasena"> <br>
        <?php if (isset($errores['nueva_contrasena'])): ?>
            <span class="error"> <?= $errores['nueva_contrasena']; ?> </span>
        <?php endif; ?> <br> 

        <label for="confirmar_nueva_contrasena"> Confirma la contraseña: </label> <br>
        <input type="password" name="confirmar_nueva_contrasena"> <br>
        <?php if (isset($errores['confirmar_nueva_contrasena'])): ?>
            <span class="error"> <?= $errores['confirmar_nueva_contrasena']; ?> </span>
        <?php endif; ?> <br> 

        <input type="submit" name="resetear" value="RESTABLECER">
    </form>
</body>
</html>