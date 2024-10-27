<!-- login.php -->
<?php

require_once('init.php');

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    die();
}

// En futuros capítulos, intentaremos autentificar con cookie-token

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
        // Accion
        $db->execute("SELECT * FROM users WHERE username = :username", [':username' => $usuario]);

        $aAVerificar = $db->getData(DBConnector::FETCH_ROW);

        if ($aAVerificar && password_verify($contrasena, $aAVerificar['userpass'])) {
            $_SESSION['user'] = $aAVerificar['username'];

            // Si se marca la opción "recuérdame"
            if (isset($_POST['recuerdame'])) {
                // Generar token
                $token = bin2hex(random_bytes(DEFAULT_TOKEN_CHARACTER_COUNT));
                $date = new DateTime();
                $date->add(new DateInterval('P7D')); // Expiración en 7 días

                // Guardar en BB.DD
                $db->execute(
                    "INSERT INTO tokens (token, user_id, expiry_date, consumed) VALUES (:token, :user_id, :expiry_date, :consumed)",
                    [
                        ':token' => $token,
                        ':user_id' => $aAVerificar['id'],
                        ':expiry_date' => $date->format("Y-m-d H:i:s"),
                        ':consumed' => TOKEN_NOT_CONSUMED_VALUE
                    ]
                );

                // Poner cookie en el cliente
                setcookie(COOKIE_REMEMBER_ME_NAME, $token, time() + DEFAULT_REMEMBER_ME_TOKEN_EXPIRATION_TIME);
            }

            // Redirigir al área privada
            header("Location: privada.php");
            die();
        } else {
            $errores = "Credenciales incorrectas";
        }
    }
}

// Pintar formulario con datos
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .error {
            color: red;
            border-color: red;
        }
    </style>
</head>
<body>
    <div>
        <div>
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
