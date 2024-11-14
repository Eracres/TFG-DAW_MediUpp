<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require UTILS_DIR . 'vendor/autoload.php';

    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    function sendEmail($email, $body) {
        $mail = new PHPMailer(true);

        try {
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = '';
            $mail->SMTPAuth = false;
            $mail->Username = '';
            $mail->Password = '';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->CharSet = 'UTF-8';
            $mail->setFrom('', '');
            $mail->addAddress($email, '');
            $mail->Subject = 'Recupera tu contraseña con MediUpp';
            $mail->Body = '';

            $mail->send();
            return true;
        } catch (Exception) {
            return false;
        }
    }