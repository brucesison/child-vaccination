<?php
// Database connection
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

// Fetch breaks for the selected date
$selectedDate = $_GET['selected_date'];
$sql = "SELECT * FROM break_tbl WHERE break_date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $selectedDate);
$stmt->execute();
$result = $stmt->get_result();

$response = array();

if ($result->num_rows > 0) {
    // Break exists for the selected date
    $row = $result->fetch_assoc();
    $response['breakExists'] = true;
    $response['reason'] = $row['reason'];
} else {
    // No break for the selected date
    $response['breakExists'] = false;
}

$stmt->close();
$conn->close();

echo json_encode($response); // Send data to JavaScript
?>
