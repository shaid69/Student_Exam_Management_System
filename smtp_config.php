<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';

function send_verification_email($email, $username, $verify_link) {
    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = 'yourgmail@gmail.com';
        $mail->Password = 'your_app_password';

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Improve Speed
        $mail->SMTPKeepAlive = true;
        $mail->SMTPDebug = 0;
        $mail->Timeout = 5;

        // Recipients
        $mail->setFrom('yourgmail@gmail.com', 'Student Exam System');
        $mail->addAddress($email, $username);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email Address';
        $mail->Body = "
            Hello $username, <br>
            Click below to verify your account: <br><br>
            <a href='$verify_link'>Verify Account</a>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        return $mail->ErrorInfo;
    }
}
?>
