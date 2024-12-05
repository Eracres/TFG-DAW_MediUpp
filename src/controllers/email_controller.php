<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TFG-DAW_MediUpp/src/utils/init.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require UTILS_DIR . 'vendor/autoload.php';

    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    function sendEmail($email, $subject, $body) {
        $mail = new PHPMailer(true);

        try {
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.educa.madrid.org';
            $mail->SMTPAuth = false;
            $mail->Username = 'malmoroxcabrera@educa.madrid.org';
            $mail->Password = 'Almoroxii1133';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->CharSet = 'UTF-8';
            $mail->setFrom('malmoroxcabrera@educa.madrid.org', 'MediUpp TFG');
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $body;

            $mail->send();
            return true;
        } catch (Exception) {
            return false;
        }
    }