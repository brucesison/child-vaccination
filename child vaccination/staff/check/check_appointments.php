<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "child_appointment";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Fetch appointments for the selected date
// $selectedDate = $_GET['selected_date'];
// $sql = "SELECT appointment_time FROM appointment_tbl WHERE appointment_date = ? AND (status = 'upcoming' OR status = 'pending')";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("s", $selectedDate);
// $stmt->execute();
// $result = $stmt->get_result();

// $bookedTimes = [];

// while ($row = $result->fetch_assoc()) {
//     $times = json_decode($row['appointment_time'], true);
//     $bookedTimes = array_merge($bookedTimes, $times);
// }

// $stmt->close();
// $conn->close();

// header('Content-Type: application/json');
// echo json_encode(['bookedTimes' => $bookedTimes]);

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "child_appointment";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the selected date from the GET request
$selectedDate = $_GET['selected_date'];
$appointmentId = $_GET['appointment_id']; // Assumes appointment ID is passed via query

// Get all booked appointment times for the selected date
$sql = "SELECT appointment_id, appointment_time FROM appointment_tbl 
        WHERE appointment_date = ? AND (status = 'upcoming' OR status = 'pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $selectedDate);
$stmt->execute();
$result = $stmt->get_result();

$bookedTimes = [];
$currentAppointmentTime = null; // To hold the current user's appointment time

while ($row = $result->fetch_assoc()) {
    $times = json_decode($row['appointment_time'], true);
    $bookedTimes = array_merge($bookedTimes, $times);

    // If the current row matches the user's appointment ID, store this time separately
    if ($row['appointment_id'] == $appointmentId) {
        $currentAppointmentTime = $times;
    }
}

$stmt->close();
$conn->close();

// Include both booked times and the user's specific appointment time in the response
header('Content-Type: application/json');
echo json_encode([
    'bookedTimes' => $bookedTimes,
    'currentAppointmentTime' => $currentAppointmentTime
]);
?>