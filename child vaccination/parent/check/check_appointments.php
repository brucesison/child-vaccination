<?php
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

// Fetch appointments for the selected date
$selectedDate = $_GET['selected_date'];
$sql = "SELECT appointment_time FROM appointment_tbl WHERE appointment_date = ? AND (status = 'upcoming' OR status = 'pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $selectedDate);
$stmt->execute();
$result = $stmt->get_result();

$bookedTimes = [];

while ($row = $result->fetch_assoc()) {
    $times = json_decode($row['appointment_time'], true);
    $bookedTimes = array_merge($bookedTimes, $times);
}

$stmt->close();
$conn->close();

echo json_encode(['bookedTimes' => $bookedTimes]);
?>
