<?php

@include 'db_connect.php';

session_start();

// Check if the parent is logged in
if (isset($_SESSION['parent_loggedin']) && $_SESSION['parent_loggedin'] === true) {
  $unique_id = $_SESSION['unique_id'];

  $status = "Offline now";
  $update = "UPDATE user_tbl SET session_status = :status WHERE unique_id = :unique_id";

  $stmt = $pdo->prepare($update);
  $stmt->execute(['status' => $status, 'unique_id' => $unique_id]);

  $_SESSION['parent_loggedin'] = false;
}

session_unset();
session_destroy();

// Redirect to the login page
header('location: login.php');
exit;

?>