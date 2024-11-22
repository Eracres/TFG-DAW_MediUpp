<!-- login.php -->
<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    checkRememberMeCookie();

    if (isset($_SESSION['logged_user'])) {
        header("Location: ../user_event_list.php");
        exit();
    }

    $log_errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send'])) {
        // Obtengo los datos del formulario
        $usern_or_email = isset($_POST['usern_or_email']) ? trim($_POST['usern_or_email']) : null;
        $password = isset($_POST['password']) ? trim($_POST['password']) : null;
        $remember_me = isset($_POST['remember_me']) ? true : false;

        // Compruebo que los campos no estén vacíos
        if (empty($usern_or_email) && empty($password)) {
            $log_errors['empty-fields'] = "Campos obligatorios";
        } else if (empty($usern_or_email)) {
            $log_errors['empty-username'] = "Usuario vacío";
        } else if (empty($password)) {
            $log_errors['empty-password'] = "Contraseña vacía";
        }

        // Si no hay errores en los campos, intento iniciar sesión
        if (empty($log_errors)) {
            if (login($usern_or_email, $password)) {
                if ($remember_me) {
                    $token = generateToken();
                    $user_id = $_SESSION['logged_user']['id'];
    
                    saveToken($token, $user_id, TOKEN_TYPE_REMEMBER_ME);

                    setcookie(COOKIE_REMEMBER_ME_NAME, $token, time() + DEFAULT_REMEMBER_ME_TOKEN_EXPIRATION_TIME);
                }
                
                header("Location: ../user_event_list.php");
                exit();
            } else {
                $log_errors['wrong-credentials'] = "Credenciales incorrectas";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | MediUpp</title>
    <meta name="description" content="MediUpp es una aplicación web para la organización de todo tipo de eventos">
    <meta name="author" content="Samuel Macias">
    <meta name="author" content="Sergio Cáceres">
    <meta name="author" content="Marcos Almorox">
    <link rel="icon" href="../../../resources/logo/Logo(final).png" type="image/x-icon">
    <link href="../../css/output.css" rel="stylesheet">
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="login-body">
    <div class="login-container">
        <img class="login-logo" src="../../../resources/logo/Logo (final).png" alt="Logo">
        <div class="login-title-container">
            <h1 class="login-title">Inicio de sesión</h1>
        </div> 
        <form action="" method="post" class="login-form">
            <input type="text" 
                   class="login-input <?php echo (!empty($errores)) ? 'login-input-error' : ''; ?>" 
                   name="usern_or_email" 
                   placeholder="Usuario" 
                   value="<?= isset($usern_or_email) ? htmlspecialchars($usern_or_email) : '' ?>">
            <input type="password" 
                   class="login-input <?php echo (!empty($errores)) ? 'login-input-error' : ''; ?>" 
                   name="password" 
                   placeholder="Contraseña">
            <?php if (!empty($errores)) { ?>
                <span class="login-error-text"><?php echo $errores ?></span>
            <?php } ?>
            <div class="login-remember">
                <input type="checkbox" name="remember_me" id="remember_me">
                <label for="remember_me">Recordar</label>
            </div>
            <input type="submit" name="send" value="Entrar" class="login-button">
        </form>
        
        <div class="login-links">
            <a href="register.php" class="login-link">¿No tienes cuenta?</a>
            <a href="recover-password.php" class="login-link">Recuperar contraseña</a>
        </div>
    </div>
</body>
</html>
