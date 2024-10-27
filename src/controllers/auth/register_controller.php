<?php

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



        // Verificar si los campos están vacíos (puedes agregar validaciones adicionales según tus requisitos)
        if (empty($first_name) || empty($last_name) || empty($usern) || empty($passw) || empty($email)) {
            die("Todos los campos son obligatorios.");
        }


         // Verificar que email y repetir-email coincidan
         if ($email !== $_POST['repetir-email']) {
            die("Los emails no coinciden.");
        }

        // Verificar que la contraseña y repetir-contraseña coincidan
        if ($passw !== $_POST['repetir-clave']) {
            die("Las contraseñas no coinciden.");
        }



        // Verificar si el email tiene un formato válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Formato de email no válido.");
        }

        // Verificar si el usuario o el email ya existen en la base de datos
        $sqlCheck = "SELECT COUNT(*) FROM users WHERE usern = :usern OR email = :email";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bindParam(':usern', $usern);
        $stmtCheck->bindParam(':email', $email);
        $stmtCheck->execute();
        $existingUser = $stmtCheck->fetchColumn();

        if ($existingUser > 0) {
            die("El nombre de usuario o email ya están registrados.");
        }

        // Hashear la contraseña
        $hashedPassword = password_hash($passw, PASSWORD_DEFAULT);

        // Insertar los datos en la base de datos usando una declaración preparada
        $sqlInsert = "INSERT INTO users (first_name, last_name, usern, passw, email) 
                      VALUES (:first_name, :last_name, :usern, :passw, :email)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bindParam(':first_name', $first_name);
        $stmtInsert->bindParam(':last_name', $last_name);
        $stmtInsert->bindParam(':usern', $usern);
        $stmtInsert->bindParam(':passw', $hashedPassword);
        $stmtInsert->bindParam(':email', $email);

        if ($stmtInsert->execute()) {
            echo "Registro exitoso.";
        } else {
            echo "Error al registrar.";
        }
    } else {
        echo "Método de solicitud no válido.";
    }

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
