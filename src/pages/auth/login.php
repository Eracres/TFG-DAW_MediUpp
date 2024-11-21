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
    <title> Iniciar sesión | MediUpp </title>
    <meta name="description" content="MediUpp es una aplicación web para la organización de todo tipo de eventos">
    <meta name="author" content="Samuel Macias">
    <meta name="author" content="Sergio Cáceres">
    <meta name="author" content="Marcos Almorox">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css"> 
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .gsi-material-button {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        -webkit-appearance: none;
        background-color: WHITE;
        background-image: none;
        border: 1px solid #747775;
        -webkit-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        color: #1f1f1f;
        cursor: pointer;
        font-family: 'Roboto', arial, sans-serif;
        font-size: 14px;
        height: 40px;
        letter-spacing: 0.25px;
        outline: none;
        overflow: hidden;
        padding: 0 12px;
        position: relative;
        text-align: center;
        -webkit-transition: background-color .218s, border-color .218s, box-shadow .218s;
        transition: background-color .218s, border-color .218s, box-shadow .218s;
        vertical-align: middle;
        white-space: nowrap;
        width: auto;
        max-width: 400px;
        min-width: min-content;
        }

        .gsi-material-button .gsi-material-button-icon {
        height: 20px;
        margin-right: 12px;
        min-width: 20px;
        width: 20px;
        }

        .gsi-material-button .gsi-material-button-content-wrapper {
        -webkit-align-items: center;
        align-items: center;
        display: flex;
        -webkit-flex-direction: row;
        flex-direction: row;
        -webkit-flex-wrap: nowrap;
        flex-wrap: nowrap;
        height: 100%;
        justify-content: space-between;
        position: relative;
        width: 100%;
        }

        .gsi-material-button .gsi-material-button-contents {
        -webkit-flex-grow: 1;
        flex-grow: 1;
        font-family: 'Roboto', arial, sans-serif;
        font-weight: 500;
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: top;
        }

        .gsi-material-button .gsi-material-button-state {
        -webkit-transition: opacity .218s;
        transition: opacity .218s;
        bottom: 0;
        left: 0;
        opacity: 0;
        position: absolute;
        right: 0;
        top: 0;
        }

        .gsi-material-button:disabled {
        cursor: default;
        background-color: #ffffff61;
        border-color: #1f1f1f1f;
        }

        .gsi-material-button:disabled .gsi-material-button-contents {
        opacity: 38%;
        }

        .gsi-material-button:disabled .gsi-material-button-icon {
        opacity: 38%;
        }

        .gsi-material-button:not(:disabled):active .gsi-material-button-state, 
        .gsi-material-button:not(:disabled):focus .gsi-material-button-state {
        background-color: #303030;
        opacity: 12%;
        }

        .gsi-material-button:not(:disabled):hover {
        -webkit-box-shadow: 0 1px 2px 0 rgba(60, 64, 67, .30), 0 1px 3px 1px rgba(60, 64, 67, .15);
        box-shadow: 0 1px 2px 0 rgba(60, 64, 67, .30), 0 1px 3px 1px rgba(60, 64, 67, .15);
        }

        .gsi-material-button:not(:disabled):hover .gsi-material-button-state {
        background-color: #303030;
        opacity: 8%;
        }
    </style>
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
