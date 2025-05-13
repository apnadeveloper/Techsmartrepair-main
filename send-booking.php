<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If you installed PHPMailer with Composer

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $_POST['name'] ?? '';
    $email   = $_POST['email'] ?? '';
    $phone   = $_POST['phone'] ?? '';
    $date    = $_POST['date'] ?? '';
    $store   = $_POST['time'] ?? '';
    $device  = $_POST['device'] ?? '';
    $plan    = $_POST['plan'] ?? '';
    $price   = $_POST['price'] ?? '';

    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
    $mail->Host = 'da-1.us.hostns.io'; // Your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'info@techsmartrepair.co.uk'; // SMTP username
    $mail->Password = 'SdAN5gCk9auBu4v9wBKS'; // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

         // Recipients
    $mail->setFrom('info@techsmartrepair.co.uk', 'Booking System');
    $mail->addAddress('info@techsmartrepair.co.uk'); // Your email
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Booking Received';

        $mail->Body = "
            <h3>Booking Details</h3>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Phone:</strong> {$phone}</p>
            <p><strong>Appointment:</strong> {$date}</p>
            <p><strong>Store:</strong> {$store}</p>
            <p><strong>Device:</strong> {$device}</p>
            <p><strong>Repair Plan:</strong> {$plan}</p>
            <p><strong>Price:</strong> {$price}</p>
        ";

        $mail->send();
        echo "<script>alert('Booking sent successfully!'); window.location.href='index.html';</script>";
    } catch (Exception $e) {
        echo "Error: Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method.";
}
