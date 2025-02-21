<?php
@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $break_id = $_GET["break_id"];

  try {
    $stmt = $pdo->prepare("DELETE FROM break_tbl WHERE break_id = ?");
    $stmt->execute([$break_id]);

    // Redirect back to appointment list
    header("Location: ../app_break.php?status=deleted_successfully");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    header("Location: ../app_break.php?status=error");
    exit();
  }
}
?>