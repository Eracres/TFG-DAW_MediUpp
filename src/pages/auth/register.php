<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    checkRememberMeCookie();
    redirectIfLoggedIn();

    //*Display para errores en pantalla
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    // var_dump($db); // Debe mostrar el objeto de la conexión, si no, error de conex.


    //*Mensajes de error
    $registro_exitoso = $error_vacio = $error_nombre = $error_usuario = $error_clave = $error_repetir_clave = $error_email = $error_repetir_email = "";
    $hay_errores = False;

    try {
        $database1 = "tfg_mediupp_local";
        $user1 = "samuel";
        $pass1 = "fritur4";
        $host1 = "localhost";
        $port1 = "3306";

        // Instancia del Singleton
        $db = DBConnector::getInstance();

        // Inicializa la conexión
        $db->initialize($database1, $user1, $pass1, $host1, "mysql", $port1, "utf8");

        // Variable booleana para errores
        $hay_errores = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Procesar los datos del formulario
            $alias = trim($_POST['nombre']);
            $bio = trim($_POST['biografia']);
            $usern = trim($_POST['usuario']);
            $passw = trim($_POST['clave']);
            $email = trim($_POST['correo']);
            $repe_email = trim($_POST['repetir-correo']);
            $repe_clave = trim($_POST['repetir-clave']);

            // Validaciones de los datos
            if (empty($alias) || empty($usern) || empty($passw) || empty($email)) {
                $error_vacio = "Rellena los campos obligatorios.";
                $hay_errores = true;
            }

            if ($email !== $repe_email) {
                $error_repetir_email = "Los emails no coinciden.";
                $hay_errores = true;
            }

            if ($passw !== $repe_clave) {
                $error_repetir_clave = "Las contraseñas no coinciden.";
                $hay_errores = true;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_email = "Formato de email no válido.";
                $hay_errores = true;
            }

            // Comprobar si el usuario o email ya existen en la base de datos
            $queryCheck = "SELECT COUNT(*) FROM users WHERE usern = :usern OR email = :email";
            $queryCheckParams = [
                ':usern' => $usern,
                ':email' => $email,
            ];

            $db->execute($queryCheck, $queryCheckParams);
            $existingUser = $db->getData(DBConnector::FETCH_COLUMN);

            if ($existingUser > 0) {
                $error_usuario = "El nombre de usuario o email ya están registrados.";
                $hay_errores = true;
            }

            // Si no hay errores, proceder con la inserción
            if (!$hay_errores) {
                // Hashear la contraseña
                $hashedPassword = password_hash($passw, PASSWORD_DEFAULT);

                // Insertar los datos
                $queryInsert = "INSERT INTO users (alias, bio, usern, passw, email) 
                                VALUES (:alias, :bio, :usern, :passw, :email)";
                $queryInsertParams = [
                    ':alias' => $alias,
                    ':bio' => $bio,
                    ':usern' => $usern,
                    ':passw' => $hashedPassword,
                    ':email' => $email,
                ];

                $db->execute($queryInsert, $queryInsertParams);
                $usuario_registrado = $db->getExecuted();

                if ($usuario_registrado) {
                    $registro_exitoso = "¡Has sido registrado con éxito! Bienvenido a MediUpp.";
                    // Redirigir después de 1 segundo
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = 'login.php';
                        }, 2500);
                        </script>";
                } else {
                    die("Error al registrar");
                }
            }
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body{
            display:flex;
            justify-content:center;
            align-items:center;
        }
        .formulario{
            width: 40%;
            height:auto;

            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;


            padding:2em;
            margin: 10px;

            background:#232323;
            color:whitesmoke;
        }
        form{
            width:80%;
            padding:10px;

            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
        }
        form div{
            width:100%;
            height:auto;

            margin:1em;
        }
        form label{
            font-size:1em;
            margin-bottom:1em;

        }
        form input{
            width:100%;
            height:2em;
            /* margin-top:10px; */
            border-radius:5px;
            background:grey;
            color:#232323;
            transition-duration:0.1s;

        }
        form input:hover{
            background:#FF6F3C;

        }

        button{
            width: 40%;
            height:3em;
            color:whitesmoke;
            background: #FF6F3C;
            font-size:1em;
            font-weight:bold;
            border:none;
            border-radius:5px;
            transition-duration:0.2s;
        }
        button:hover{
            color:#FF6F3C;
            background:#232323;
            border:1px solid #FF6F3C;

            -webkit-box-shadow: 0px 0px 18px -1px rgba(255,111,60,1);
            -moz-box-shadow: 0px 0px 18px -1px rgba(255,111,60,1);
            box-shadow: 0px 0px 18px -1px rgba(255,111,60,1);

        }


    </style>
</head>
<body>

    <div class="formulario" id="register-form">
        <img src="" alt="LOGO">

        <form action="" method="POST">
        <?php printSuccess($registro_exitoso)?>

            <div>
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre']); ?>">
                <?php printError($error_vacio);?>
            </div>
            <div>
                <label for="biografia">Biografía</label>
                <input placeholder="Cuéntanos algo sobre ti." type="text" id="biografia" name="biografia" value="<?php echo htmlspecialchars($_POST['biografia']); ?>">
            </div>
            <div>
                <label for="usuario">Nombre de usuario</label>
                <input type="text" id="usuario" name="usuario" required value="<?php echo htmlspecialchars($_POST['usuario']); ?>">
                <?php printError($error_usuario);?>
            </div>
            <div>
                <label for="clave">Contraseña</label>
                <input type="password" id="clave" name="clave" required value="<?php echo htmlspecialchars($_POST['clave']); ?>">
                <?php printError($error_clave);?>


            </div>
            <div>
                <label for="repetir-clave">Confirmar contraseña</label>
                <input type="password" id="repetir-clave" name="repetir-clave" required>    
                <?php printError($error_repetir_clave);?>

            </div>
            <div>
                <label for="correo">Dirección de e-mail</label>
                <input type="email" id="correo" name="correo" required <?php echo htmlspecialchars($_POST['correo']); ?>>
                <?php printError($error_email);?>

            </div>
            <div>
                <label for="repetir-email">Confirmar E-mail</label>
                <input type="email" id="repetir-correo" name="repetir-correo" required>            
                <?php printError($error_repetir_email);?>

            </div>
            <button type="submit" id="btn-enviar" name="enviar">Crear cuenta</button>            
            <?php printError($error_vacio)?>

        </form>

    </div>

</body>
</html>