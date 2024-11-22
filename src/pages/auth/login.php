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
<body>
    <div class="">
        <div class="">
            <h1> Inicio de sesión </h1>
            <form action="" method="post">
                <input type="text" class="<?php echo (!empty($errores)) ? 'error' : ''; ?>" name="usern_or_email" placeholder="Usuario" value="<?= isset($usern_or_email) ? htmlspecialchars($usern_or_email) : "" ?>"><br><br>
                <input type="password" class="<?php echo (!empty($errores)) ? 'error' : ''; ?>" name="password" placeholder="Contraseña"><br><br>
                <?php if (!empty($errores)) { ?>
                    <span class="error"><?php echo $errores ?></span><br><br>
                <?php } ?>
                <input type="checkbox" name="remember_me"> Recordar<br><br>
                <button type="submit" name="send" id=""> Entrar </button>
            </form> <br>
            <div>
                <?php include COMPONENTS_DIR . 'google-log_button.php'; ?>
            </div>
        </div>
    </div>
</body>
</html>
