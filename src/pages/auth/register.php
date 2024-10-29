<?php
//require_once '../utils/db/DBConnector.php';
// $CTR = "../../controllers/auth/register_controller.php";
require_once '../../utils/init.php';



try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Establecer el modo de errores de PDO en excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si los datos se han enviado correctamente
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $usern = trim($_POST['usern']);
        $passw = trim($_POST['passw']);
        $email = trim($_POST['email']);

        $repe_email = trim($_POST['repetir-email']);
        $repe_clave = trim($_POST['repetir-clave']);



        // Verificar si los campos están vacíos
        if (empty($first_name) || empty($last_name) || empty($usern) || empty($passw) || empty($email)) {
            die("Todos los campos son obligatorios."); //! Debe ser un p txt-error
        }


         // Verificar que email y repetir-email coincidan
         if ($email !== $repe_email) {
            die("Los emails no coinciden."); //! Debe ser un p txt-error
        }

        // Verificar que la contraseña y repetir-contraseña coincidan
        if ($passw !== $repe_clave) {
            die("Las contraseñas no coinciden."); //! Debe ser un p txt-error
        }



        // Verificar si el email tiene un formato válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Formato de email no válido."); //! Debe ser un p txt-error
        }

        // Verificar si el usuario o el email ya existen en la base de datos
        $sqlCheck = "SELECT COUNT(*) FROM users WHERE usern = :usern OR email = :email";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bindParam(':usern', $usern);
        $stmtCheck->bindParam(':email', $email);
        $stmtCheck->execute();
        $existingUser = $stmtCheck->fetchColumn();

        if ($existingUser > 0) {
            die("El nombre de usuario o email ya están registrados."); //! Debe ser un p txt-error
        }

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
            echo "Error al registrar."; //! Debe ser un p txt-error
        }
    } else {
        die("Método de solicitud no válido."); //DEBE ser un die
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
                <label for="usuario">Nombre de usuario</label>
                <input type="text" id="usuario" name="usuario">
            </div>
            <div>
                <label for="clave">Contraseña</label>
                <input type="password" id="clave" name="clave">            

            </div>
            <div>
                <label for="repetir-clave">Confirmar contraseña</label>
                <input type="password" id="repetir-clave" name="repetir-clave">            

            </div>
            <div>
                <label for="email">Dirección de e-mail</label>
                <input type="email" id="" name="email">            
            </div>
            <div>
                <label for="repetir-email">Confirmar E-mail</label>
                <input type="email" id="" name="repetir-email">            

            </div>
            <button type="submit" id="btn-enviar" name="enviar">Crear cuenta</button>            


        </form>

    </div>
    
    

</body>
</html>