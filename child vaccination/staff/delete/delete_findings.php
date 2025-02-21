<?php
@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $checkup_id = $_POST["checkup_id"];
  $child_id = $_POST['child_id'];

  try {
    $stmt = $pdo->prepare("DELETE FROM checkup_findings_tbl WHERE checkup_id = ?");
    $stmt->execute([$checkup_id]);

    // Redirect back to appointment list
    header("Location: ../child_findings.php?child_id=$child_id&status=deleted_successfully");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    header("Location: ../child_findings.php?child_id=$child_id&status=error");
    exit();
  }
}
?>