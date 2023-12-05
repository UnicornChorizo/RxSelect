<?php
// Establish a database connection (replace with your database credentials)
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "patientdb";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the list of doctors from the database
$sql = "SELECT id, first_name, last_name, specialty FROM doctors";
$result = $conn->query($sql);

$doctors = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctor = array(
            'id' => $row['id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'specialty' => $row['specialty']
        );
        $doctors[] = $doctor;
    }
}

// Close the database connection
$conn->close();

// Return the list of doctors as JSON
header('Content-Type: application/json');
echo json_encode($doctors);
?>
