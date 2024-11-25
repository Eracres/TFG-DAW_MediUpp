<!-- email_templates/recovery-password_email.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recupera tu contraseña</title>
    <style>
        .email-container {
            font-family: Arial, sans-serif;
            margin: 0 auto;
            padding: 20px;
            max-width: 600px;
            background-color: #f7f7f7;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }
        #email-title {
            color: #333;
        }
        .email-body {
            text-align: center;
            color: #333;
        }
        #email-body-text {
            color: #333;
        }
        .email-reset-btn {
            margin-top: 20px;
        }
        #reset-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="" alt="">
            <h2 id="email-title"> Recupera tu contraseña con MediUpp </h2>
        </div>
        <div class="email-body">
            <span id="email-body-text"> Haz clic en el siguiente botón para restablecer tu contraseña: </span>
            <div class="email-reset-btn">
                <a href="<?= htmlspecialchars($recovery_link); ?>">
                    <button id="reset-btn">
                        Restablece tu contraseña
                    </button>
                </a>
            </div>
        </div>
    </div>
</body>
</html>