<!-- login.php -->
<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    checkRememberMeCookie();
    redirectIfLoggedIn();

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

                    setcookie(COOKIE_REMEMBER_ME_NAME, $token, time() + DEFAULT_REMEMBER_ME_TOKEN_EXPIRATION_TIME, "/");
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
    <title> Inicio de sesión | MediUpp </title>
    <meta name="description" content="MediUpp es una aplicación web para la organización de todo tipo de eventos">
    <meta name="author" content="Samuel Macias">
    <meta name="author" content="Sergio Cáceres">
    <meta name="author" content="Marcos Almorox">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="login-body">
    <div class="login-container">
        <div class="login-container-content">
            <img class="login-logo" src="../../resources/logo/logo.png" alt="Logo">
            <div class="login-title-container">
                <h1 class="login-title"> Inicio de sesión </h1>
            </div> 
            <div class="login-form">
                <form action="" method="post">
                    <div>
                        <input type="text" 
                            class="login-input<?= isset($log_errors['empty-fields']) || isset($log_errors['empty-username']) ? ' form-input-error' : ''; ?>" 
                            name="usern_or_email" 
                            placeholder="Nombre de usuario o correo electrónico" 
                            value="<?= isset($usern_or_email) ? htmlspecialchars($usern_or_email) : '' ?>">
                        <?php if (isset($log_errors['empty-username'])) : ?>
                            <span class="form-error-text"> <?= $log_errors['empty-username']; ?> </span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <input type="password" 
                            class="login-input<?= isset($log_errors['empty-fields']) || isset($log_errors['empty-password']) ? ' form-input-error' : ''; ?>" 
                            name="password" 
                            placeholder="Contraseña">
                        <?php if (isset($log_errors['empty-password'])) : ?>
                            <span class="form-error-text"> <?= $log_errors['empty-password']; ?> </span>
                        <?php endif; ?>
                    </div>
                    <div class="login-remember">
                        <input type="checkbox" name="remember_me" id="remember_me">
                        <label for="remember_me"> Recordarme </label>
                    </div>
                    <button type="submit" name="send" class="login-button"> Entrar </button>
                </form>
            </div>
            <div class="login-links">
                <a href="register.php" class="login-link"> ¿No tienes cuenta? Regístrate </a>
                <a href="recover_password.php" class="login-link"> Recupera tu contraseña </a>
            </div>
            <div>
                <?php include COMPONENTS_DIR . 'google-log_button.php'; ?>
            </div>
        </div>
    </div>
</body>
</html>
