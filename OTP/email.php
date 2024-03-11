<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include Composer's autoloader
require 'vendor/autoload.php';

// Function to send OTP
function send_otp($to, $subject, $content) {
    // Create a PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'adhi42342@gmail.com'; // Replace with your email
        $mail->Password   = 'bpib hmsf jxls fedh'; // Replace with your password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('adhi42342@gmail.com', 'OTP For Login');
        $mail->addAddress($to, 'Verify Email');

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<font color='green' size='4'>Your OTP For Login: $content <br> This OTP is Valid For Only One Time. </font>";

        // Send email
        $mail->send();
        echo 'OTP has been sent successfully';
    } catch (Exception $e) {
        // Log error and display user-friendly message
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        echo "Sorry, something went wrong. Please try again later.";
    }
}

// Check if form is submitted
if(isset($_POST['to'], $_POST['subject'], $_POST['message'])) {
    // Sanitize input
    $to = filter_var($_POST['to'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $content = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    // Send email
    send_otp($to, $subject, $content);
}
?>


