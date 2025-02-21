<?php
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

// Fetch break for the selected date
$selectedDate = $_GET['selected_date'];
$sql = "SELECT reason FROM break_tbl WHERE break_date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $selectedDate);
$stmt->execute();
$result = $stmt->get_result();

$breakExists = false;
$reason = '';

if ($row = $result->fetch_assoc()) {
    $breakExists = true;
    $reason = $row['reason'];
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode(['breakExists' => $breakExists, 'reason' => $reason]);
?>
