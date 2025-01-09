<?php

require '../vendor/autoload.php'; // Adjust path as necessary

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($to, $sender = "seawzhiyi12345@gmail.com") {
    $subject = "Order Confirmation";
    $message = "Hello, this is the body of the email.";
    
    $mail = new PHPMailer(true); // Create a new PHPMailer instance

    try {
        // Server settings
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'flizy0924@gmail.com'; // Your SMTP username (email)
        $mail->Password = 'Sherkee2024.com'; // Your SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom($sender, 'Seaw Zhi Yi'); // Sender's email and name
        $mail->addAddress($to); // Add a recipient
        $mail->addReplyTo($sender); // Add a reply-to address

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send(); // Send the email
        echo "Email sent successfully!";
    } catch (Exception $e) {
        echo "Failed to send email. Mailer Error: {$mail->ErrorInfo}";
    }
}
