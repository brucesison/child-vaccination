<?php 

// Database connection parameters
@include 'includes/db_connect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $appointment_id = $_POST["appointment_id"];
  $status = $_POST["status"];

  try{
    $stmt = $pdo->prepare("UPDATE appointment_tbl SET status = :status WHERE appointment_id = :appointment_id");
    $stmt->bindParam(':appointment_id', $appointment_id);
    $stmt->bindParam(':status', $status);
    $stmt->execute();

    header("Location: app_upcoming.php?status=done");
    // exit();
  } catch (PDOException $e) {
    // Handle database errors
    // header("Location: app_upcoming.php?status=error");
    echo "Database error: " . $e->getMessage();
    // exit();
  }
}

?>