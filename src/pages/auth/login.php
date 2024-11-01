<!-- login.php -->
<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    checkRememberMeCookie();

    if (isset($_SESSION['logged_user'])) {
        header("Location: " . PAGES_DIR . "user_event_list.php");
        exit();
    }

    $errores = [];
    $usuario = "";
    $contrasena = "";

    // Si se está enviando
    if (isset($_POST['enviar'])) {
        // Cargo datos
        $usuario = isset($_POST['nombre']) ? $_POST['nombre'] : null;
        $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : null;

        // Verifico errores
        if (empty($usuario) || empty($contrasena)) {
            $errores = "Campos obligatorios";
        }

        // Si no hay errores
        if (empty($errores)) {
            if (login($usuario, $contrasena)) {
                if (isset($_POST['recuerdame'])) {
                    // Generar token
                    $token = generateToken();
                    $user_id = $_SESSION['logged_user']['id'];
    
                    saveToken($token, $user_id, TOKEN_TYPE_REMEMBER_ME);

                    setcookie(COOKIE_REMEMBER_ME_NAME, $token, time() + DEFAULT_REMEMBER_ME_TOKEN_EXPIRATION_TIME);
                }
                
                header("Location: ../user_event_list.php");
                exit();
            } else {
                $errores = "Credenciales incorrectas";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Iniciar sesión | MediUpp </title>
    <meta name="description" content="MediUpp es una aplicación web para la organización de todo tipo de eventos">
    <meta name="author" content="Samuel Macias">
    <meta name="author" content="Sergio Cáceres">
    <meta name="author" content="Marcos Almorox">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css"> 
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .error {
            color: red;
            border-color: red;
        }
    </style>
</head>
<body>
    <div class="">
        <div class="">
            <h1> Inicio de sesión </h1>
            <form action="" method="post">
                <input type="text" class="<?php echo (!empty($errores)) ? 'error' : ''; ?>" name="nombre" placeholder="Usuario" value="<?= htmlspecialchars($usuario) ?>"><br><br>
                <input type="password" class="<?php echo (!empty($errores)) ? 'error' : ''; ?>" name="contrasena" placeholder="Contraseña"><br><br>
                <?php if (!empty($errores)) { ?>
                    <span class="error"><?php echo $errores ?></span><br><br>
                <?php } ?>
                <input type="checkbox" name="recuerdame"> Recordar<br><br>
                <input type="submit" name="enviar" value="Login">
            </form>
        </div>
    </div>
</body>
</html>
