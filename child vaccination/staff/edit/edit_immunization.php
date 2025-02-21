<?php

@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $child_id = $_POST['child_id'];
  $immunization_id = $_POST['immunization_id'];
  $vaccine = $_POST['vaccine'];
  $dose = $_POST['dose'];
  $reaction = $_POST['reaction'];
  $date = $_POST['date'];
  $pedia = $_POST['pedia'];
  $doc_name = $_POST['pediatrician'];
  $pediatrician = $pedia . ' ' . $doc_name;
  $next_vaccine = $_POST['next_vaccine'];
  $next_appointment = $_POST['next_appointment'];

  // Format (capitalize each word)
  $reaction = ucwords(strtolower($reaction));

  try {
    $stmt = $pdo->prepare("UPDATE immunization_tbl SET vaccine = :vaccine, dose = :dose, reaction = :reaction, date = :date, pediatrician = :pediatrician, next_vaccine = :next_vaccine, next_appointment = :next_appointment WHERE immunization_id = :immunization_id");

    $stmt->bindParam(':vaccine', $vaccine);
    $stmt->bindParam(':dose', $dose);
    $stmt->bindParam(':reaction', $reaction);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':pediatrician', $pediatrician);
    $stmt->bindParam(':next_vaccine', $next_vaccine);
    $stmt->bindParam(':next_appointment', $next_appointment);
    $stmt->bindParam(':immunization_id', $immunization_id);
    $stmt->execute();

    header("Location: ../child_immunization.php?child_id=$child_id&status=updated");
    exit();
  } catch (PDOException $e) {
    // header("Location: ../view_vaccine.php");
    // exit();
    echo "Database error: " . $e->getMessage();

  }
}

?>