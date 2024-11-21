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
    <title>Resetear tu contraseña</title>
    <link rel="icon" href="../../../resources/logo/Logo(final).png" type="image/x-icon">
    <link href="../../css/output.css" rel="stylesheet">
</head>
<body class="reset-body">
    <div class="reset-container">
        <img src="../../../resources/logo/Titulo(final).png" alt="Logo" class="reset-logo">
        <div class="login-title-container">
            <h2 class="login-title">Resetea tu contraseña</h2>
        </div> 
        <?php if (isset($exito)) : ?>
            <span class="exito"> <?= $exito ?> </span>
        <?php endif; ?>
        <?php if (isset($errors['general'])) : ?>
            <span class="error"> <?= $errors['general'] ?> </span>
        <?php endif; ?>
        <form action="<?= $_SERVER["REQUEST_URI"]; ?>" method="post" class="reset-form">
            <div class="reset-field">
                <label for="nueva_contrasena" class="reset-label">Nueva contraseña:</label>
                <input type="password" id="nueva_contrasena" name="new_password" class="reset-input" required>
                <?php if (isset($errors['new_password'])): ?>
                    <span class="error"> <?= $errors['new_password']; ?> </span>
                <?php endif; ?>
            </div>
            <div class="reset-field">
                <label for="confirmar_nueva_contrasena" class="reset-label">Confirma la contraseña:</label>
                <input type="password" id="confirmar_nueva_contrasena" name="new_password_confirm" class="reset-input" required>
                <?php if (isset($errors['new_password_confirm'])): ?>
                    <span class="error"> <?= $errors['new_password_confirm']; ?> </span>
                <?php endif; ?>
                <?php if (isset($errors['passwords_not_match'])): ?>
                    <span class="error"> <?= $errors['passwords_not_match']; ?> </span>
                <?php endif; ?>
            </div>
            <button type="submit" name="reset" class="reset-button">Restablecer</button>
        </form>
    </div>
</body>
</html>
