<?php

@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $vaccine_id = $_POST['vaccine_id'];
  $vaccine_name = $_POST['vaccine_name'];
  $quantity = $_POST['quantity'];

  try {
    $stmt = $pdo->prepare("UPDATE vaccine_tbl SET vaccine_name = :vaccine_name, quantity = :quantity WHERE vaccine_id = :vaccine_id");

    $stmt->bindParam(':vaccine_id', $vaccine_id);
    $stmt->bindParam(':vaccine_name', $vaccine_name);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->execute();

    header("Location: ../list_vaccine.php?status=updated");
    exit();
  } catch (PDOException $e) {
    // header("Location: ../view_vaccine.php");
    // exit();
    echo "Database error: " . $e->getMessage();

  }
}

?>