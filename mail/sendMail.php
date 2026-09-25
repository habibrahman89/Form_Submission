<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/src/Exception.php';
require_once __DIR__ . '/src/PHPMailer.php';
require_once __DIR__ . '/src/SMTP.php';

function sendMail($name, $email, $contact, $gender, $message) {

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "conversiontechnology.in@gmail.com";
        $mail->Password = "wpknmfmkypdhfeor"; // app password without spaces
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = "UTF-8";

        // Sender
        $mail->setFrom("conversiontechnology.in@gmail.com", "Form Notification");

        // Receiver (primary)
        $mail->addAddress("habib408@gmail.com");

        // Optional — backup receiver for reliable inbox delivery
        // $mail->addAddress("no-reply@technomedia.liveblog365.com");

        $mail->isHTML(true);
        $mail->Subject = "New Form Submission - $name";
        $mail->Body = "
            <h3>New Submission Received</h3>
            <strong>Name:</strong> $name <br>
            <strong>Email:</strong> $email <br>
            <strong>Contact:</strong> $contact <br>
            <strong>Gender:</strong> $gender <br>
            <strong>Message:</strong> $message <br>
        ";

        // NO echo, NO debug → keep JSON response clean
        return $mail->send() ? true : false;

    } catch (Exception $e) {
        return false;
    }
}