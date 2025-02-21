<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'child_appointment';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT break_date, reason FROM break_tbl";
$result = $conn->query($sql);

$breaks = array();
while ($row = $result->fetch_assoc()) {
  $breaks[] = $row;
}

echo json_encode($breaks);

$conn->close();
?>