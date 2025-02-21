<?php
@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $immunization_id = $_POST["immunization_id"];
  $child_id = $_POST['child_id'];

  try {
    $stmt = $pdo->prepare("DELETE FROM immunization_tbl WHERE immunization_id = ?");
    $stmt->execute([$immunization_id]);

    // Redirect back to appointment list
    header("Location: ../child_immunization.php?child_id=$child_id&status=deleted_successfully");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    header("Location: ../child_immunization.php?child_id=$child_id&status=error");
    exit();
  }
}
?>