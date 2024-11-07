<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

redirectIfLoggedIn();

//*Display para errores en pantalla
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// var_dump($db); // Debe mostrar el objeto de la conexión, si no, error de conex.

function printError($mensaje){
    echo '<p class="text-red-600" style="color:red">'.$mensaje.'</p>';
}

//*Mensajes de error
$error_vacio = $error_nombre = $error_usuario = $error_clave = $error_repetir_clave = $error_email = $error_repetir_email = "";
$hay_errores = False;

try {
    $database1 = "tfg_mediupp_local";
    $user1 = "samuel";
    $pass1 = "fritur4";
    $host1 = "localhost";
    $port1 = "3306";
    //TODO ^^^^^^ esto debería ser innecesario porque ya está hecho en el init ¿?------------------------------------------
    // $db = DBConnector::getInstance();
    $conn = $db->getConnection();

    // Inicializa la conexión
    $db->initialize($database1, $user1, $pass1, $host1, "mysql", $port1, "utf8");

    //Variable booleana para errores, si es True, no inserta

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Procesar los datos del formulario
        $first_name = trim($_POST['nombre']);
        $last_name = trim($_POST['apellido']);
        $usern = trim($_POST['usuario']);
        $passw = trim($_POST['clave']);
        $email = trim($_POST['correo']);

        $repe_email = trim($_POST['repetir-correo']);
        $repe_clave = trim($_POST['repetir-clave']);

        // Verificar si algún campo está vacío
        if (empty($first_name) || empty($usern) || empty($passw) || empty($email)) {
            $error_vacio = "Rellena los campos obligatorios.";
            $hay_errores = True;
        }

        // Verificar que email y repe-email coincidan
        if ($email !== $repe_email) {
            $error_repetir_email = "Los emails no coinciden."; //! Debe ser un p txt-error
            $hay_errores = True;
        }

        // Verificar que contraseña y repe-contraseña coincidan
        if ($passw !== $repe_clave) {
            $error_repetir_clave = "Las contraseñas no coinciden."; //! Debe ser un p txt-error
            $hay_errores = True;
        }

        // Verificar formato del email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_email = "Formato de email no válido."; //! Debe ser un p txt-error
            $hay_errores = True;
        }

        // Verificar si el usuario o el email ya existen en la base de datos
        $sqlCheck = "SELECT COUNT(*) FROM users WHERE usern = :usern OR email = :email";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bindParam(':usern', $usern);
        $stmtCheck->bindParam(':email', $email);
        $stmtCheck->execute();
        $existingUser = $stmtCheck->fetchColumn();

        if ($existingUser > 0) {
            $error_usuario = "El nombre de usuario o email ya están registrados."; //! Debe ser un p txt-error
            $hay_errores = True;
        }

        //Frenar la inserción si hay errores
        if(!$hay_errores){
                // Hashear la contraseña
            $hashedPassword = password_hash($passw, PASSWORD_DEFAULT);

            // Insertar los datos del registro en la BD 
            $sqlInsert = "INSERT INTO users (first_name, last_name, usern, passw, email) 
                        VALUES (:first_name, :last_name, :usern, :passw, :email)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bindParam(':first_name', $first_name);
            $stmtInsert->bindParam(':last_name', $last_name);
            $stmtInsert->bindParam(':usern', $usern);
            $stmtInsert->bindParam(':passw', $hashedPassword);
            $stmtInsert->bindParam(':email', $email);

            if ($stmtInsert->execute()) {
                echo "Registro exitoso."; //* Debe ser un p txt-success
            } else {
                die("Error al registrar"); //! Debe ser un p txt-error
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
            <div>
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre']); ?>">
                <?php printError($error_vacio);?>
            </div>
            <div>
                <label for="apellido">Apellido(s)</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($_POST['apellido']); ?>">
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