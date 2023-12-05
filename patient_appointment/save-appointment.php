<?php
session_start();

// Establish a database connection
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "patientdb";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables to store form data
$firstName = $lastName = $email = $phone = $appointmentDate = $appointmentTime = $message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize input
    $firstName = sanitizeInput($_POST["firstName"]);
    $lastName = sanitizeInput($_POST["lastName"]);
    $email = sanitizeInput($_POST["email"]);
    $phone = sanitizeInput($_POST["phone"]);
    $appointmentDate = sanitizeInput($_POST["appointmentDate"]);
    $appointmentTime = sanitizeInput($_POST["appointmentTime"]);
    $message = sanitizeInput($_POST["message"]);

    // Validate and process the data as needed (e.g., validation checks)

    // Prepare and execute a SQL query to insert data into the database
    $sql = "INSERT INTO appointments (first_name, last_name, email, phone, appointment_date, appointment_time, message) 
            VALUES ('$firstName', '$lastName', '$email', '$phone', '$appointmentDate', '$appointmentTime', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully
        $_SESSION['appointment_success'] = true;

        // Redirect the user to the confirmation page
        header("Location: appointment-confirmation.php");
        exit();
    } else {
        // Error in inserting data
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}

// Function to sanitize user input
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
