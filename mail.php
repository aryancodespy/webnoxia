<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // or manually require PHPMailer classes if not using Composer

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input
    $name    = strip_tags(trim($_POST["name"] ?? ''));
    $email   = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone   = strip_tags(trim($_POST["phone"] ?? ''));
    $subject = strip_tags(trim($_POST["subject"] ?? ''));
    $message = strip_tags(trim($_POST["message"] ?? ''));
    $cc      = filter_var(trim($_POST["cc"] ?? ''), FILTER_SANITIZE_EMAIL);
    $bcc     = filter_var(trim($_POST["bcc"] ?? ''), FILTER_SANITIZE_EMAIL);

    // Validate required fields
    if (!$name || !$email || !$message || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please fill in all required fields correctly.";
        exit;
    }

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'aryan.webnoxia@gmail.com'; // Change this
        $mail->Password   = 'vwil wjed uhxc rsjk'; // Use App Password
        $mail->SMTPSecure = 'TLS'; // or 'ssl'
        $mail->Port       = 587; // or 465 for ssl

        // Sender & Recipients
        $mail->setFrom('aryan@webnoxia.com', 'Webnoxia Contact');
        $mail->addAddress('aryan.webnoxia@gmail.com', 'Webnoxia'); // Your destination email

        // Optional: Reply-To, CC, BCC
        $mail->addReplyTo($email, $name);
        if ($cc && filter_var($cc, FILTER_VALIDATE_EMAIL)) {
            $mail->addCC($cc);
        }
        if ($bcc && filter_var($bcc, FILTER_VALIDATE_EMAIL)) {
            $mail->addBCC($bcc);
        }

        // File Attachment
        if (!empty($_FILES['attachment']['name'])) {
            $fileTmpPath = $_FILES['attachment']['tmp_name'];
            $fileName    = basename($_FILES['attachment']['name']);
            $mail->addAttachment($fileTmpPath, $fileName);
        }

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = $subject ?: 'New message from Webnoxia';
        $mail->Body    = "
            <h2>Contact Form Submission</h2>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Phone:</strong> {$phone}</p>
            <p><strong>Message:</strong><br>{$message}</p>
        ";
        $mail->AltBody = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";

        $mail->send();
        http_response_code(200);
        echo "Your message has been sent successfully.";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Mail could not be sent. Error: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(403);
    echo "Access Denied.";
}
?>
