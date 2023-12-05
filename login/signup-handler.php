<?php
// Start a session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $id = $_POST["id"];
    $fullname = $_POST["fullname"];
    $phonenumber = $_POST["phonenumber"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Establish a database connection
    $db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "patientdb";

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the email is already registered
    $check_email_sql = "SELECT * FROM patients WHERE email = '$email'";
    $check_email_result = $conn->query($check_email_sql);

    if ($check_email_result->num_rows > 0) {
        // Email is already registered
        echo "Email is already registered. Please use a different email address.";
    } else {
        // Insert the new user into the database
        $insert_sql = "INSERT INTO patients (id, fullname, phonenumber, email, password) VALUES ('$id', '$fullname', '$phonenumber', '$email', '$hashed_password')";

        if ($conn->query($insert_sql) === TRUE) {
            // Registration successful, redirect to the login page
            header("Location: login.html");
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
}
?>
