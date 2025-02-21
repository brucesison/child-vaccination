<?php

@include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Retrieve form data
  $incoming_id = $_POST['staff_id'];
  $outgoing_id = $_POST['unique_id'];
  $message = $_POST['msg'];
  $time_stamp = date('Y-m-d H:i:s');
  $status = "not seen";

  try {
    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, time_stamp, status) VALUES (:incoming_id, :outgoing_id, :message, :time_stamp, :status)");

    // Bind parameters
    $stmt->bindParam(':incoming_id', $incoming_id);
    $stmt->bindParam(':outgoing_id', $outgoing_id);
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':time_stamp', $time_stamp);
    $stmt->bindParam(':status', $status);
    $stmt->execute();

    header("Location: ../meet.php");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    // header("Location: ../list_vaccine.php?status=error");
    echo "Database error: " . $e->getMessage();
  }
}
?>