<?php
@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $staff_id = $_GET["staff_id"];

  try {
    $stmt = $pdo->prepare("DELETE FROM staff_tbl WHERE staff_id = ?");
    $stmt->execute([$staff_id]);

    // Redirect back to appointment list
    header("Location: ../admins.php?status=deleted_successfully");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    header("Location: ../admins.php?status=error");
    exit();
  }
}
?>