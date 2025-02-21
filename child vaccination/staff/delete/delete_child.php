<?php
@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $child_id = $_GET["child_id"];

  try {
    $stmt = $pdo->prepare("DELETE FROM immunization_tbl WHERE child_id = ?");
    $stmt->execute([$child_id]);

    $stmt = $pdo->prepare("DELETE FROM checkup_findings_tbl WHERE child_id = ?");
    $stmt->execute([$child_id]);

    $stmt = $pdo->prepare("DELETE FROM child_tbl WHERE child_id = ?");
    $stmt->execute([$child_id]);

    // Redirect back to child list
    header("Location: ../list_child_table.php?status=deleted_successfully");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    header("Location: ../list_child_table.php?status=error");
    exit();
  }
}
?>