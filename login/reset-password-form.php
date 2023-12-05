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
