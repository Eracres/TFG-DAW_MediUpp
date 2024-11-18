<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

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
            $recovery_email_body = COMPONENTS_DIR . "/email_templates/recovery_password_email.php";

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
    <title> Recuperar contraseña </title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <h2> Recupera tu contraseña </h2>
    <?php if (isset($correo_enviado) && $correo_enviado) : ?>
        <span class="exito"> <?= $mensaje_exito; ?> </span>
    <?php elseif (isset($correo_enviado)): ?> 
        <span class="error"> Ha habido un error al enviar el correo electrónico </span>
    <?php endif; ?>
    <form action="" method="post">
        <label for="correo_recuperacion"> Correo electrónico asociado a la cuenta: </label> <br>
        <input type="email" name="recovery_email"> <br>
        <?php if (isset($mensaje_error)) : ?>
            <span class="error"> <?= $mensaje_error; ?> </span>
        <?php endif; ?> <br>

        <button type="submit" name="send" id=""> Enviar </button>
    </form>
</body>
</html>