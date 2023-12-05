<?php
session_start();

// Check if the 'patient_id' session variable is not set
if (!isset($_SESSION["patient_id"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../login/login.html");
    exit();
}

// Establish a database connection (you should replace these with your actual database credentials)
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "admin_database";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle bill payment logic when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the bill_id from the form
    $bill_id = $_POST["bill_id"];

    // Update the bill status and payment date
    $update_sql = "UPDATE bills SET status = 'Paid', payment_date = NOW() WHERE bill_id = $bill_id";

    if ($conn->query($update_sql) === TRUE) {
        echo "Bill payment successful!";
    } else {
        echo "Error updating bill: " . $conn->error;
    }
}

// Query to retrieve unpaid bills for the specific user
$user_id = $_SESSION['patient_id'];
$sql = "SELECT * FROM bills WHERE user_id = $user_id AND status = 'Unpaid'";

$result = $conn->query($sql);

// Gets name for the user profile.
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $patient_name = $row["fullname"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Bills</title>
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
                <a href="../patient_portal/patient-portal.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <img src="../images/pill-svgrepo-com.svg" width="40" height="32" class="bi me-2">
                    <span class="fs-4">Navigation</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li>
                        <a href="../patient_portal/patient-portal.php" class="nav-link active" aria-current="page">
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
                        <a href="../patient_billing/view-bills.php" class="nav-link link-dark">
                            <img src="../images/search-svgrepo-com.svg" alt="" width="20" height="20"
                                class="rounded-circle me-2">
                            View Bills
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-cen
                    ter link-dark text-decoration-none dropdown-toggle"
                        id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../images/user-circle-svgrepo-com.svg" alt="" width="32" height="32"
                            class="rounded-circle me-2">
                        <strong> <?php echo $patient_name; ?> </strong>
                    </a>
                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                        <li><a class="dropdown-item" href="../patient_portal/patient-portal.php"> <?php echo $patient_name; ?> </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../patient_setting/patient-settings.php">Settings</a></li>
                        <li><a class="dropdown-item" href="../login/logout.php">Sign out</a></li>
                    </ul>
                </div>
            </div>

        <div class="container">
            <section id="pay-bills">
                <h2>Pay Bills</h2>
                <ul id="bill-list">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Display unpaid bills with an option to pay
                            echo "<li>";
                            echo "Bill ID: " . $row["bill_id"] . "<br>";
                            echo "Amount: $" . $row["amount"] . "<br>";
                            echo "Due Date: " . $row["due_date"] . "<br>";
                            echo "Status: " . $row["status"] . "<br>";
                            if ($row["status"] == "Unpaid") {
                                // Display a form to pay the bill
                                echo "<form method='post' action='pay_bills.php'>";
                                echo "<input type='hidden' name='bill_id' value='" . $row["bill_id"] . "'>";
                                echo "<input type='submit' value='Pay Bill'>";
                                echo "</form>";
                            }
                            echo "</li>";
                        }
                    } else {
                        echo "<p>No unpaid bills found for this user.</p>";
                    }
                    ?>
                </ul>
            </section>
        </div>
    </main>
    <script src="../patient_js/patient-script.js"></script>
</body>
</html>
