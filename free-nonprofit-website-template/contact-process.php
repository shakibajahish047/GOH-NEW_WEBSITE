<?php
// Load PHPMailer classes from src folder
require __DIR__ . '/src/Exception.php';
require __DIR__ . '/src/PHPMailer.php';
require __DIR__ . '/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 2; 
        $mail->Debugoutput = 'html';
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'goha-afg.org';   // check in hosting panel
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@goha-afg.org';   // your official email
        $mail->Password   = 'System@1256';         // your email password
        $mail->SMTPSecure = 'ssl';                 // or 'tls'
        $mail->Port       = 465;                   // 465 for SSL, 587 for TLS

        // Sender & recipient
        $mail->setFrom('info@goha-afg.org', 'Gate of Hope Website');
        $mail->addAddress('info@goha-afg.org');    // where to receive it
        $mail->addReplyTo($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<b>Name:</b> $name<br><b>Email:</b> $email<br><br>$message";
        $mail->AltBody = "Name: $name\nEmail: $email\n\n$message";

        $mail->send();
        echo "Message has been sent!";
    } catch (Exception $e) {
        echo " Message could not be sent. Error: {$mail->ErrorInfo}";
    }
}
