<?php

@include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {

  // Retrieve form data
  $incoming_id = $_GET['incoming_id'];
  $outgoing_id = $_GET['outgoing_id'];
  $link_ended = $_GET['room_name'];
  $message = 'Call ended';
  $time_stamp = date('Y-m-d H:i:s');
  $status = "not seen";

  try {
    // Prepare the SQL statement

    $stmt = $pdo->prepare("DELETE FROM messages WHERE msg = ?");
    $stmt->execute([$link_ended]);

    $stmt = $pdo->prepare("INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, time_stamp, status) VALUES (:incoming_id, :outgoing_id, :message, :time_stamp, :status)");

    // Bind parameters
    $stmt->bindParam(':incoming_id', $incoming_id);
    $stmt->bindParam(':outgoing_id', $outgoing_id);
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':time_stamp', $time_stamp);
    $stmt->bindParam(':status', $status);
    $stmt->execute();

    header("Location: ../chats.php");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    // header("Location: ../list_vaccine.php?status=error");
    echo "Database error: " . $e->getMessage();
  }
}
?>