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
$db_name = "patientdb";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the patient's information based on their session ID
$patient_id = $_SESSION['patient_id'];
$sql = "SELECT * FROM patients WHERE id = $patient_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $patient_name = $row["fullname"];
    $patient_email = $row["email"];
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the entered current password
    $current_password = mysqli_real_escape_string($conn, $_POST["current_password"]);

    // Prepare and execute a SQL query to retrieve the hashed password from the database
    $password_sql = "SELECT password FROM patients WHERE id = $patient_id";
    $password_result = $conn->query($password_sql);

    if ($password_result->num_rows == 1) {
        $password_row = $password_result->fetch_assoc();
        $hashed_password = $password_row["password"];

        // Verify the entered current password
        if (password_verify($current_password, $hashed_password)) {
            // The current password is correct; proceed with updates

            // Initialize an array to hold the fields and values to update
            $update_data = array();

            // Check if new name is provided
            if (!empty($_POST["new_name"])) {
                $new_name = mysqli_real_escape_string($conn, $_POST["new_name"]);
                $update_data[] = "fullname = '$new_name'";
            }

            // Check if new email is provided
            if (!empty($_POST["new_email"])) {
                $new_email = mysqli_real_escape_string($conn, $_POST["new_email"]);
                $update_data[] = "email = '$new_email'";
            }

            // Check if new password is provided
            if (!empty($_POST["new_password"])) {
                $new_password = mysqli_real_escape_string($conn, $_POST["new_password"]);
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_data[] = "password = '$hashed_password'";
            }

            // Construct the SQL update query
            if (!empty($update_data)) {
                $update_sql = "UPDATE patients SET " . implode(", ", $update_data) . " WHERE id = $patient_id";
                if ($conn->query($update_sql) === TRUE) {
                    // Update successful, redirect to the patient portal or any other page
                    header("Location: ../patient_portal/patient-portal.php");
                    exit();
                } else {
                    // Handle update error
                    echo "Error updating patient information: " . $conn->error;
                }
            } else {
                // No fields were updated, display a message
                echo "No fields were updated.";
            }
        } else {
            // Current password is incorrect
            echo "Incorrect current password." . "<br>";
        }
    } else {
        // Error occurred while retrieving the current password
        echo "Error retrieving current password." . "<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="../patient_css/styles.css">
    <link href="../patient_css/sidebars.css" rel="stylesheet">
    <script defer src="../patient_js/sidebars.js"></script>
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
        <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
            <a href="../patient_portal/patient-portal.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="../images/pill-svgrepo-com.svg" width="40" height="32" class="bi me-2">
                <span class="fs-4">Navigation</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li>
                    <a href="../patient_portal/patient-portal.php" class="nav-link link-dark">
                        <img src="../images/home-svgrepo-com.svg" alt="" width="20" height="20" class="rounded-circle me-2">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../patient_appointment/request-appointment.php" class="nav-link link-dark">
                        <img src="../images/table-svgrepo-com.svg" alt="" width="20" height="20" class="rounded-circle me-2">
                        Request Appointment
                    </a>
                </li>
                <li>
                    <a href="../patient_prescription/see-prescriptions.php" class="nav-link link-dark">
                        <img src="../images/search-svgrepo-com.svg" alt="" width="20" height="20" class="rounded-circle me-2">
                        View Prescription
                    </a>
                </li>
                <li>
                    <a href="../patient_billing/view-bills.php" class="nav-link link-dark">
                        <img src="../images/search-svgrepo-com.svg" alt="" width="20" height="20" class="rounded-circle me-2">
                        View Bills
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../images/user-circle-svgrepo-com.svg" alt="" width="32" height="32" class="rounded-circle me-2">
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

        <div class="container" style="padding-top: 15px;">
            <section id="settings">
                <h2>Update Your Information</h2>
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="new_name" name="new_name" value="<?php echo $patient_name; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="new_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="new_email" name="new_email" value="<?php echo $patient_email; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </section>
        </div>
    </main>
    <script src="../patient_js/patient-script.js"></script>
</body>

</html>
