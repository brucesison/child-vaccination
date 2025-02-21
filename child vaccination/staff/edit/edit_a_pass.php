<?php

@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $staff_id = $_POST['staff_id'];
  $pass = md5($_POST["pass"]);

  try {
    $stmt = $pdo->prepare("UPDATE staff_tbl SET pass = :pass WHERE staff_id = :staff_id");
    $stmt->bindParam(':pass', $pass);
    $stmt->bindParam(':staff_id', $staff_id);
    $stmt->execute();
    header("Location: ../view_myprofile.php?status=pass_updated");
    exit();
  } catch (PDOException $e) {
    header("Location: ../view_myprofile.php?status=error");
    exit();
  }
}

?>