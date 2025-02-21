<?php
@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $vaccine_id = $_GET["vaccine_id"];

  try {
    $stmt = $pdo->prepare("DELETE FROM vaccine_tbl WHERE vaccine_id = ?");
    $stmt->execute([$vaccine_id]);

    // Redirect back to appointment list
    header("Location: ../list_vaccine.php?status=deleted_successfully");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    header("Location: ../list_vaccine.php?status=error");
    exit();
  }
}
?>