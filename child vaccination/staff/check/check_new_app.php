<?php

@include "../includes/db_connect.php";

// Prepare the SQL query to count new appointment requests
$sql = "SELECT COUNT(*) AS count FROM appointment_tbl WHERE status = 'pending'";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Fetch the result as an associative array
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
  echo $row['count']; // Return the count as the response
} else {
  echo 0; // No requests
}

exit();

?>