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

// Fetch child count for the given appointment ID
$appointmentId = $_GET['appointment_id'];
$sql = "SELECT child_name FROM appointment_tbl WHERE appointment_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $appointmentId);
$stmt->execute();
$result = $stmt->get_result();

$childCount = 0;

if ($row = $result->fetch_assoc()) {
    $childNames = json_decode($row['child_name'], true);
    $childCount = count($childNames);
}

$stmt->close();
$conn->close();

echo json_encode(['child_count' => $childCount]);
?>
