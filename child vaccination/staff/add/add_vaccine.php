<?php

@include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Retrieve form data
  $vaccine_name = $_POST['vaccine_name'];
  $quantity = $_POST['quantity'];

  // Format (capitalize each word)
  $vaccine_name = ucwords(strtolower($vaccine_name));

  try {
    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO vaccine_tbl (vaccine_name, quantity) VALUES (:vaccine_name, :quantity)");

    // Bind parameters
    $stmt->bindParam(':vaccine_name', $vaccine_name);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->execute();

    header("Location: ../list_vaccine.php?status=added_successfully");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    header("Location: ../list_vaccine.php?status=error");
  }
}
?>