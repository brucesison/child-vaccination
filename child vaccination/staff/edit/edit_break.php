<?php

@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $break_id = $_POST['break_id'];
  $break_date = $_POST['break_date'];
  $reason = $_POST['reason'];

  try {
    $stmt = $pdo->prepare("UPDATE break_tbl SET break_date = :break_date, reason = :reason WHERE break_id = :break_id");

    $stmt->bindParam(':break_id', $break_id);
    $stmt->bindParam(':break_date', $break_date);
    $stmt->bindParam(':reason', $reason);
    $stmt->execute();

    header("Location: ../app_break.php?status=updated");
    exit();
  } catch (PDOException $e) {
    // header("Location: ../view_vaccine.php");
    // exit();
    echo "Database error: " . $e->getMessage();

  }
}

?>