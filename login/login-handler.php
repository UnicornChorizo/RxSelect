<?php
session_start(); // Start a session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve patient input
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Establish a database connection (replace with your database credentials)
    $db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "patientdb";

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute a SQL query to retrieve patient information
    $sql = "SELECT * FROM patients WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];
        $id = $row["id"]; // Get the patient_id

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, create a session and redirect with patient_id
            $_SESSION["patient_id"] = $id; // Store patient ID in session
            if($id == 6) {
                 header("Location: http://localhost:8080/patient/all");
            } else if ($id == 7) {
                header("Location: http://localhost:8080/admin/dashboard");
            } else {
                header("Location: ../patient_portal/patient-portal.php?patient_id=" . $id); // Redirect with patient_id in the URL
            }
            exit(); // Ensure no further code execution after the redirect
        } else {
            // Password is incorrect
            echo "Incorrect password." . "<br>";
        }
    } else {
        // Patient with the provided email doesn't exist
        echo "Patient not found.";
    }    

    // Close the database connection
    $conn->close();
}
?>
