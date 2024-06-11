<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/composer/vendor/autoload.php'; // Ensure the path is correct

$mail = new PHPMailer(true); // Passing `true` enables exceptions

try {
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = '41d8c9900b45a9';
    $mail->Password = '824ee0f2e06aaf';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 2525;


    // Sender and recipient settings
    $mail->setFrom('luciapalicaciones@mailtrap.io', 'luciaaplicaciones');
    $mail->addReplyTo('info@mailtrap.io', 'Mailtrap');
    $mail->addAddress('recipient1@mailtrap.io', 'Tim'); // Primary recipient
    // CC and BCC
    $mail->addCC('cc1@example.com', 'Elena');
    $mail->addBCC('bcc1@example.com', 'Alex');
    // Adding more BCC recipients
    $mail->addBCC('bcc2@example.com', 'Anna');
    $mail->addBCC('bcc3@example.com', 'Mark');

    // Email content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = "PHPMailer SMTP test";
    $mail->Body = '<h1>Send HTML Email using SMTP in PHP</h1><p>This is a test email I\'m sending using SMTP mail server with PHPMailer.</p>'; // Example HTML body
    $mail->AltBody = 'This is the plain text version of the email content';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
