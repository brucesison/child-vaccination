<?php

include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Retrieve form data
  $child_id = $_POST['child_id'];
  $date = $_POST['date'];
  $vaccine = $_POST['vaccine'];
  $dose = $_POST['dose'];
  $doc = $_POST['doc'];
  $doc_name = $_POST['pediatrician'];
  $pediatrician = $doc . ' ' . $doc_name;
  $reaction = $_POST['reaction'];
  $next_vaccine = $_POST['next_vaccine'];
  $next_appointment = $_POST['next_appointment'];
  $record_type = $_POST['record_type'];

  // Format (capitalize each word)
  $vaccine = ucwords(strtolower($vaccine));
  $reaction = ucwords(strtolower($reaction));
  $pediatrician = ucwords(strtolower($pediatrician));

  try {
    // Prepare the SQL statement

    $stmt = $pdo->prepare("INSERT INTO immunization_tbl (child_id, date, vaccine, dose, pediatrician, reaction, next_vaccine, next_appointment, record_type) VALUES (:child_id, :date, :vaccine, :dose, :pediatrician, :reaction, :next_vaccine, :next_appointment, :record_type)");

    // Bind parameters
    $stmt->bindParam(':child_id', $child_id);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':vaccine', $vaccine);
    $stmt->bindParam(':dose', $dose);
    $stmt->bindParam(':pediatrician', $pediatrician);
    $stmt->bindParam(':reaction', $reaction);
    $stmt->bindParam(':next_vaccine', $next_vaccine);
    $stmt->bindParam(':next_appointment', $next_appointment);
    $stmt->bindParam(':record_type', $record_type);
    $stmt->execute();

    header("Location: ../child_immunization.php?child_id=$child_id&status=added_successfully");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    // header("Location: ../child_immunization.php?child_id=$child_id&status=error");
    // echo $child_id;
    // echo $date;
    // echo $vaccine;
    // echo $dose;
    // echo $pediatrician;
    // echo $reaction;
    // echo $next_appointment;
    // Handle database errors
    echo "Database error: " . $e->getMessage();
  }
}
?>