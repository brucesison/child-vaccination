<?php

@include 'db_connect.php';

if (isset($_GET['email'])) {
  $email = $_GET['email'];
  $code = 0;
  try {
    // Prepare and execute the update statement
    $update = "UPDATE user_tbl SET code = :code WHERE email = :email";
    $stmt = $pdo->prepare($update);
    $stmt->execute(['code' => $code, 'email' => $email]);

    // Redirect to the login page
    header('Location: parent_login.php');
    exit;
  } catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    echo 'An error occurred while updating your code. Please try again later.';
  }
}

?>