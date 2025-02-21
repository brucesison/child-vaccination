<?php 

@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $parent_id = $_POST['user_id'];
  $pass = md5($_POST["pass"]);

  try {
      $stmt = $pdo->prepare("UPDATE user_tbl SET pass = :pass WHERE user_id = :user_id");
      $stmt->bindParam(':pass', $pass);
      $stmt->bindParam(':user_id', $parent_id);
      $stmt->execute();
      header("Location: ../view_parent.php?user_id=$parent_id&status=password_updated");
      exit();
    } catch (PDOException $e) {
      header("Location: ../view_parent.php?user_id=$parent_id&status=error");
      exit();
  }
}

?>