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
            $errors['new_password'] = "Debes introducir una nueva contraseña";
        } 

        if (empty($new_password_confirm)) {
            $errors['new_password_confirm'] = "Debes confirmar la nueva contraseña";
        } elseif (!empty($new_password) && !hash_equals($new_password, $new_password_confirm)) {
        //} elseif (!empty($new_password) && $new_password !== $new_password_confirm) {
            $errors['passwords_not_match'] = "Las contraseñas deben coincidir";
        }

        if (empty($errors)) {
            
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Resetear tu contraseña </title>
    <link rel="stylesheet" href="css/estilos.css">
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