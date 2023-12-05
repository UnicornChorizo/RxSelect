<?php
session_start();

// Check if the session variable is set to indicate success and if the recent appointment ID is set
if (isset($_SESSION['appointment_success'], $_SESSION['recent_appointment_id']) && $_SESSION['appointment_success'] === true) {
    // Establish a database connection
    $db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "patientdb";

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve the most recent appointment ID from the session
    $appointmentId = $_SESSION['recent_appointment_id'];

    // Fetch appointment date and time from the database based on the appointment ID
    $sql = "SELECT appointment_date, appointment_time FROM appointments WHERE id = '$appointmentId'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Data fetched successfully
        $row = $result->fetch_assoc();
        $appointmentDate = $row['appointment_date'];
        $appointmentTime = $row['appointment_time'];
    } else {
        // Handle the case where no data was found in the database
        $appointmentDate = "N/A";
        $appointmentTime = "N/A";
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle the case where the session variables are not set
    $appointmentDate = "N/A";
    $appointmentTime = "N/A";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmed</title>
    <link rel="stylesheet" href="styles.css">
    <link href="sidebars.css" rel="stylesheet">
    <script defer src="sidebars.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
    <div class="titlebar">
        <div class="titlebar_text">
            <strong>RxSelect</strong>
        </div>
    </div>

    <main>
        <div class="container center-content">
            <!-- Confirmation message -->
            <section id="confirmation-message" class="confirmation-message">
                <h2>Appointment Confirmed</h2>
                <p>Your appointment has been scheduled for:</p>
                <p id="appointment-details">
                    Date: <span id="appointmentDate"><?= $appointmentDate; ?></span> <br>
                    Time: <span id="appointmentTime"><?= $appointmentTime; ?></span>
                </p>

                <a href="patient-portal.php" class="btn btn-primary">Return to Patient Portal</a>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const appointmentDateElement = document.getElementById("appointmentDate");
            const appointmentTimeElement = document.getElementById("appointmentTime");

            // Check if the session variable is set to indicate success
            const isAppointmentSuccess = <?= isset($_SESSION['appointment_success']) ? 'true' : 'false'; ?>;

            if (isAppointmentSuccess) {
                // You can update the appointment details here
                const appointmentDateText = "<?= $appointmentDate; ?>";
                const appointmentTimeText = "<?= $appointmentTime; ?>";

                // Update the date and time elements
                appointmentDateElement.textContent = appointmentDateText;
                appointmentTimeElement.textContent = appointmentTimeText;

                // Unset the session variable to avoid showing the message again on page refresh
                <?php unset($_SESSION['appointment_success']); ?>;
            }
        });
    </script>

</body>

</html>