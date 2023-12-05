<?php
session_start();

// Check if the 'patient_id' session variable is not set
if (!isset($_SESSION["patient_id"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../login/login.html");
    exit();
}

// Establish a connection to the database
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "code-review";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection to database failed: " . $conn->connect_error);
}

// Retrieve patient information from the 'patients' table
$patient_id = $_SESSION['patient_id'];
$sql_patient = "SELECT * FROM bills WHERE patient_id = $patient_id";

$result_patient = $conn->query($sql_patient);

if ($result_patient->num_rows == 1) {
    $row_patient = $result_patient->fetch_assoc();
} else {
    // echo "User not found in the database.";
}

// Retrieve bill information from the 'bills' table for the current patient
$sql_bills = "SELECT * FROM bills WHERE patient_id = $patient_id"; // Update table name to 'bills'
$result_bills = $conn->query($sql_bills);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bills</title>
    <link rel="stylesheet" href="../patient_css/styles.css">
    <link href="../patient_css/sidebars.css" rel="stylesheet">
    <script defer src="../patient_js/sidebars.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="titlebar">
        <div class="titlebar_text">
            <strong>RxSelect</strong>
        </div>
    </div>

    <main>
        <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
            <a href="../patient_portal/patient-portal.php"
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="../images/pill-svgrepo-com.svg" width="40" height="32" class="bi me-2">
                <span class="fs-4">Navigation</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li>
                    <a href="../patient_portal/patient-portal.php" class="nav-link link-dark">
                        <img src="../images/home-svgrepo-com.svg" alt="" width="20" height="20"
                            class="rounded-circle me-2">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../patient_appointment/request-appointment.php" class="nav-link link-dark">
                        <img src="../images/table-svgrepo-com.svg" alt="" width="20" height="20"
                            class="rounded-circle me-2">
                        Request Appointment
                    </a>
                </li>
                <li>
                    <a href="../patient_prescription/see-prescriptions.php" class="nav-link link-dark">
                        <img src="../images/search-svgrepo-com.svg" alt="" width="20" height="20"
                            class="rounded-circle me-2">
                        View Prescription
                    </a>
                </li>
                <li>
                    <a href="../patient_billing/view-bills.php" class="nav-link active" aria-current="page">
                        <img src="../images/search-svgrepo-com.svg" alt="" width="20" height="20"
                            class="rounded-circle me-2">
                        View Bills
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                    id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../images/user-circle-svgrepo-com.svg" alt="" width="32" height="32"
                        class="rounded-circle me-2">
                    <strong> Romario Barahona </strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="../patient_portal/patient-portal.php"> Romario Barahona </a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../patient_setting/patient-settings.php">Settings</a></li>
                    <li><a class="dropdown-item" href="../login/logout.php">Sign out</a></li>
                </ul>
            </div>
        </div>

        <div class="container">
            <section id="view-bills">
                <h2>View Bills</h2>
                <ul id="bill-list">
                    <?php
                    if ($result_bills->num_rows > 0) {
                        while ($row = $result_bills->fetch_assoc()) {
                            // Display bill information
                            echo "<li>";
                            echo "Bill ID: " . $row["bill_id"] . "<br>";
                            echo "Amount: $" . $row["amount"] . "<br>";
                            echo "Reason for Visit: " . $row["reason_for_visit"] . "<br>";
                            // You can display more bill details as needed
                            echo "</li>";
                        }
                    } else {
                        echo "<p>No bills found for this user.</p>";
                    }
                    ?>
                </ul>
            </section>
        </div>
    </main>
    <script src="../patient_js/patient-script.js"></script>
</body>

</html>
