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

    // ✅ Validation 
    if (strlen($name) < 3 || strlen($name) > 50) {
        die("❌ Name must be between 3 and 50 characters.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("❌ Invalid email address.");
    }
    if (strlen($subject) < 5 || strlen($subject) > 100) {
        die("❌ Subject must be between 5 and 100 characters.");
    }
    if (strlen($message) < 10 || strlen($message) > 1000) {
        die("❌ Message must be between 10 and 500 characters.");
    }

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0; // بهتره ۰ باشه در حالت نهایی
        $mail->isSMTP();
        $mail->Host       = 'goha-afg.org';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@goha-afg.org';
        $mail->Password   = 'System@1256';  // ⚠️ توصیه میشه در config جدا ذخیره کنی
        $mail->SMTPSecure = 'ssl';          
        $mail->Port       = 465;

        $mail->setFrom('info@goha-afg.org', 'Gate of Hope Website');
        $mail->addAddress('info@goha-afg.org');
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<b>Name:</b> $name<br><b>Email:</b> $email<br><br>$message";
        $mail->AltBody = "Name: $name\nEmail: $email\n\n$message";

        $mail->send();
        echo "✅ Message has been sent!";
    } catch (Exception $e) {
        echo "❌ Message could not be sent. Error: {$mail->ErrorInfo}";
    }
}
