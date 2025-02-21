<?php

@include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Retrieve form data
  $checkup_id = $_POST['checkup_id'];
  $child_id = $_POST['child_id'];
  $checkup_date = $_POST['checkup_date'];
  $weight = $_POST['weight'];
  $height = $_POST['height'];
  $head_circumference = $_POST['head_circumference'];
  $chest_circumference = $_POST['chest_circumference'];
  $immunization_status = $_POST['immunization_status'];
  $developmental_milestones = $_POST['developmental_milestones'];
  $physical_exam = $_POST['physical_exam'];
  $medical_history = $_POST['medical_history'];
  $assessment_recommendations = $_POST['assessment_recommendations'];
  $notes = $_POST['notes'];

  // Format (capitalize each word)
  $immunization_status = ucwords(strtolower($immunization_status));
  $developmental_milestones = ucwords(strtolower($developmental_milestones));
  $physical_exam = ucwords(strtolower($physical_exam));
  $medical_history = ucwords(strtolower($medical_history));
  $assessment_recommendations = ucwords(strtolower($assessment_recommendations));
  $notes = ucwords(strtolower($notes));


  try {
    // Prepare the SQL statement
    $stmt = $pdo->prepare("UPDATE checkup_findings_tbl SET checkup_date = :checkup_date, weight = :weight, height = :height, head_circumference = :head_circumference, chest_circumference = :chest_circumference, developmental_milestones = :developmental_milestones, physical_exam = :physical_exam, immunization_status = :immunization_status, medical_history = :medical_history, assessment_recommendations = :assessment_recommendations, notes = :notes WHERE (checkup_id = :checkup_id)");

    // Bind parameters
    $stmt->bindParam(':checkup_id', $checkup_id);
    $stmt->bindParam(':checkup_date', $checkup_date);
    $stmt->bindParam(':weight', $weight);
    $stmt->bindParam(':height', $height);
    $stmt->bindParam(':head_circumference', $head_circumference);
    $stmt->bindParam(':chest_circumference', $chest_circumference);
    $stmt->bindParam(':developmental_milestones', $developmental_milestones);
    $stmt->bindParam(':physical_exam', $physical_exam);
    $stmt->bindParam(':immunization_status', $immunization_status);
    $stmt->bindParam(':medical_history', $medical_history);
    $stmt->bindParam(':assessment_recommendations', $assessment_recommendations);
    $stmt->bindParam(':notes', $notes);
    $stmt->execute();

    header("Location: ../child_findings.php?child_id=$child_id&status=updated");
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