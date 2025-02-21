<?php

@include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Retrieve form data
  $break_date = $_POST['break_date'];
  $reason = $_POST['reason'];

  // Format (capitalize each word)
  $reason = ucfirst(strtolower($reason));

  try {
    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO break_tbl (break_date, reason) VALUES (:break_date, :reason)");

    // Bind parameters
    $stmt->bindParam(':break_date', $break_date);
    $stmt->bindParam(':reason', $reason);
    $stmt->execute();

    header("Location: ../app_break.php?status=added_successfully");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    header("Location: ../app_break.php?status=error");
  }
}
?>