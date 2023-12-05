<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../plugins/PHPMailer-master/src/Exception.php';
require '../plugins/PHPMailer-master/src/PHPMailer.php';
require '../plugins/PHPMailer-master/src/SMTP.php';

if (isset($_POST["reset-request-submit"])) {
    $email = $_POST["email"];

    // Generate a random token
    $token = bin2hex(random_bytes(32));

    // Store the token in your database along with the email and a timestamp

    // Create a password reset link
    $reset_link = "https://localhost:3000/RxSelectDemo/login/reset-password.php?email=$email&token=$token";

    // Send the password reset email
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.sendgrid.net'; // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'apikey';
        $mail->Password = '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';
        $mail->SMTPSecure = 'tls'; // Change to 'ssl' if required
        $mail->Port = 587; // Change to 465 if using 'ssl'

        // Recipients
        $mail->setFrom('romario.barahona@gmail.com', 'Admin');
        $mail->addAddress($email); // Recipient's email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body = "Click the following link to reset your password: $reset_link";

        $mail->send();
        echo 'A password reset link has been sent to your email address.';
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body>
    <h2>Reset Your Password</h2>
    <form method="post" action="reset-password.php">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <button type="submit" name="reset-request-submit">Reset Password</button>
    </form>
</body>
</html>

