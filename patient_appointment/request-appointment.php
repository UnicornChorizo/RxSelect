<?php
session_start();

// Check if the 'patient_id' session variable is not set
if (!isset($_SESSION["patient_id"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.html");
    exit();
}

// Establish a database connection
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "patientdb";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$patient_id = $_SESSION["patient_id"];

$sql = "SELECT fullname FROM patients WHERE id = '$patient_id'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $patient_name = $row["fullname"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST["firstName"];
    $last_name = $_POST["lastName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $doctor_name = $_POST["doctorName"];
    $appointment_date = $_POST["appointmentDate"];
    $appointment_time = $_POST["appointmentTime"];
    $message = $_POST["message"];

    // Prepare and execute the SQL statement to insert appointment data
    $insert_sql = "INSERT INTO appointments (first_name, last_name, email, phone, doctor_name, appointment_date, appointment_time, message) VALUES ('$first_name', '$last_name', '$email', '$phone', '$doctor_name', '$appointment_date', '$appointment_time', '$message')";

    if ($conn->query($insert_sql) === TRUE) {
        // Data inserted successfully
        $appointmentId = $conn->insert_id;

        // Store the appointment ID in the session
        $_SESSION['recent_appointment_id'] = $appointmentId;

        // Data inserted successfully
        $_SESSION['appointment_success'] = true;

        // Redirect to the confirmation page
        header("Location: appointment-confirmation.php");
        exit();
    } else {
        // Error in inserting data
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Appointment</title>
    <link rel="stylesheet" href="../patient_css/styles.css">
    <link href="../patient_css/sidebars.css" rel="stylesheet">
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

        <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;" style="height: 100vh;">
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
                    <a href="../patient_appointment/request-appointment.php" class="nav-link active" aria-current="page">
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
                    <strong><?php echo $patient_name; ?></strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="../patient_portal/patient-portal.php"><?php echo $patient_name; ?></a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../patient_setting/patient-settings.php">Settings</a></li>
                    <li><a class="dropdown-item" href="../login/logout.php">Sign out</a></li>
                </ul>
            </div>
        </div>

        <div class="container" style="padding-top: 15px;">
            <section id="request-appointment">
                <div class="appointment-form">
                    <h2>Doctor Appointment Request</h2>
                    <form id="appointment-form" method="post">
                        <div class="input-group">
                            <label for="firstName">First Name:</label>
                            <input type="text" id="firstName" name="firstName" required>
                        </div>

                        <div class="input-group">
                            <label for="lastName">Last Name:</label>
                            <input type="text" id="lastName" name="lastName" required>
                        </div>

                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>

                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" required>

                        <label for="doctor">Select Doctor:</label>
                        <select id="doctor" name="doctor" required>
                            <option value="" disabled selected>Select a doctor</option>
                        </select>
                        <input type="hidden" id="doctorName" name="doctorName">

                        <label for="appointment-date">Preferred Appointment Date</label>
                        <input type="date" id="appointment-date" name="appointmentDate" required>

                        <label for="appointmentTime">Choose Time:</label>
                        <select id="appointmentTime" name="appointmentTime">
                        </select>

                        <label for="message">Message (Optional)</label>
                        <textarea id="message" name="message" rows="4"></textarea>

                        <button type="submit" id="submit-button">Submit</button>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <script>
        // Generate Appointment Time Slots
        document.addEventListener("DOMContentLoaded", function() {
            const appointmentTimeSelect = document.getElementById("appointmentTime");

            // Generate time slots from 8 AM to 5 PM, every 15 minutes
            const startTime = new Date();
            startTime.setHours(8, 0, 0);
            const endTime = new Date();
            endTime.setHours(17, 0, 0);
            const timeInterval = 15;

            while (startTime <= endTime) {
                const option = document.createElement("option");
                const timeString = startTime.toLocaleTimeString([], {
                    hour: "2-digit",
                    minute: "2-digit"
                });
                option.text = timeString;
                option.value = timeString;
                appointmentTimeSelect.appendChild(option);

                // Increment time by 15 minutes
                startTime.setTime(startTime.getTime() + timeInterval * 60000);
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            const doctorSelect = document.getElementById("doctor");
            const doctorNameInput = document.getElementById("doctorName");

            // Fetch the list of doctors from the server and populate the dropdown
            fetch("get-doctors.php")
                .then((response) => response.json())
                .then((data) => {
                    doctorSelect.innerHTML = "<option value='' disabled selected>Select a doctor</option>";

                    data.forEach((doctor) => {
                        const option = document.createElement("option");
                        option.value = doctor.id;
                        option.text = `${doctor.first_name} ${doctor.last_name} - ${doctor.specialty}`;
                        doctorSelect.appendChild(option);
                    });
                })
                .catch((error) => {
                    console.error("Error fetching doctors:", error);
                });

            doctorSelect.addEventListener("change", function() {
                const selectedOption = doctorSelect.options[doctorSelect.selectedIndex];
                const selectedDoctorName = selectedOption.text.split(" - ")[0];
                doctorNameInput.value = selectedDoctorName;
            });
        });
    </script>
</body>

</html>