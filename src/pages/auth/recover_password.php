<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    checkRememberMeCookie();
    redirectIfLoggedIn();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send'])) {
        $recovery_email = isset($_POST['recovery_email']) ? trim($_POST['recovery_email']) : null;

        if (empty($recovery_email)) {
            $error = "Debes introducir tu correo de recuperación";
        } elseif (!validateEmail($recovery_email)) {
            $error = "Debes introducir un correo válido";
        }

        if (empty($error)) {
            $token = generateToken();

            $valid_user_id = getUserIdByEmail($recovery_email);
            
            if ($valid_user_id) {
                saveToken($token, $valid_user_id, TOKEN_TYPE_RECOVERY_PASSWORD);
            } 

            $recovery_link = "http://localhost/TFG-DAW_MediUpp/src/auth/reset_password.php?token=$token";
            $recovery_email_subject = "Recupera tu contraseña con MediUpp";
            
            ob_start();
            $body_template_path = COMPONENTS_DIR . "/email_templates/recovery_password_email.php";
            include $body_template_path;

            $recovery_email_body = ob_get_clean();

            $sending_success = sendEmail($recovery_email, $recovery_email_subject, $recovery_email_body);

            if ($sending_success) {

            } else {
                
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Recupera tu contraseña | MediUpp </title>
    <meta name="description" content="MediUpp es una aplicación web para la organización de todo tipo de eventos">
    <meta name="author" content="Samuel Macias">
    <meta name="author" content="Sergio Cáceres">
    <meta name="author" content="Marcos Almorox">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="recover-body">
    <div class="recover-container">
        <img src="../../resources/logo/logo.png" alt="Logo" class="recover-logo">
        <div class="login-title-container">
            <h2 class="login-title">Recupera tu contraseña</h2>
        </div>
        <form action="" method="post" class="recover-form">
            <label for="recovery_email" class="recover-label"> Correo electrónico asociado a la cuenta: </label>
            <input type="email" 
                class="recover-input<?= isset($error) ? ' form-input-error' : ''; ?>"
                name="recovery_email"
                placeholder="Tu correo electrónico"
                value="<?= isset($recovery_email) ? htmlspecialchars($recovery_email) : '' ?>">
            <?php if (isset($error)) : ?>
                <span class="form-error-text"> <?= $error; ?> </span>
            <?php endif; ?>

            <button type="submit" name="send" class="recover-button"> Enviar </button>
        </form>
    </div>
</body>
</html>