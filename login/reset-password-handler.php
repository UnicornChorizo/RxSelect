<?php
if (isset($_POST["reset-password-submit"])) {
    $email = $_POST["email"];
    $token = $_POST["token"];
    $newPassword = $_POST["new-password"];
    $confirmPassword = $_POST["confirm-password"];

    // Validate the token and email from the database
    // Make sure the token has not expired

    if ($newPassword === $confirmPassword) {
        // Hash the new password and update it in the database
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in your database

        echo 'Password has been reset successfully!';
    } else {
        echo 'Passwords do not match.';
    }
}
?>
