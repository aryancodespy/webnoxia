<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # Replace with the recipient email
    $mail_to = "USEREMAIL@gmail.com";

    # Sender Data
    $name = trim(strip_tags($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = trim(strip_tags($_POST["subject"]));
    $message = trim(strip_tags($_POST["message"]));

    # Validate Input
    if (empty($name) || strlen($name) < 2 || 
        !filter_var($email, FILTER_VALIDATE_EMAIL) || 
        empty($subject) || strlen($subject) < 3 || 
        empty($message)) {
        http_response_code(400);
        echo "Please complete the form with valid inputs and try again.";
        exit;
    }

    # Mail Content
    $content = "Name: $name\n";
    $content .= "Email: $email\n";
    $content .= "Subject: $subject\n\n";
    $content .= "Message:\n$message\n";

    # Email Headers
    $headers = "From: $name <$email>";

    # Send the email
    if (mail($mail_to, $subject, $content, $headers)) {
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        http_response_code(500);
        error_log("Mail failed: " . json_encode($_POST)); // Log for debugging
        echo "Oops! Something went wrong, we couldn't send your message.";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
