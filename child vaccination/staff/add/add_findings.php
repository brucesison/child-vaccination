<?php

@include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Retrieve form data
  $child_id = $_POST['child_id'];
  $checkup_date = date('Y-m-d');

  $weight = !empty($_POST['weight_input']) ? $_POST['weight_input'] : $_POST['weight_select'];
  $height = !empty($_POST['height_input']) ? $_POST['height_input'] : $_POST['height_select'];
  $chest = !empty($_POST['chest_input']) ? $_POST['chest_input'] : $_POST['chest_select'];
  $head = !empty($_POST['head_input']) ? $_POST['head_input'] : $_POST['head_select'];

  // $weight = $_POST['weight'];
  // $height = $_POST['height'];
  // $head_circumference = $_POST['head_circumference'];
  // $chest_circumference = $_POST['chest_circumference'];
  // $immunization_status = $_POST['immunization_status'];
  $immunization_status = !empty($_POST['immu_stat_input']) ? $_POST['immu_stat_input'] : $_POST['immu_stat_select'];
  $developmental_milestones = !empty($_POST['dev_milestones_input']) ? $_POST['dev_milestones_input'] : $_POST['dev_milestones_select'];
  $physical_exam = !empty($_POST['physical_exam_input']) ? $_POST['physical_exam_input'] : $_POST['physical_exam_select'];
  $medical_history = !empty($_POST['medical_history_input']) ? $_POST['medical_history_input'] : $_POST['medical_history_select'];
  $assessment_recommendations = !empty($_POST['assessment_recommendations_input']) ? $_POST['assessment_recommendations_input'] : $_POST['assessment_recommendations_select'];
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
    $stmt = $pdo->prepare("INSERT INTO checkup_findings_tbl (child_id, checkup_date, weight, height, head_circumference, chest_circumference, developmental_milestones, physical_exam, immunization_status, medical_history, assessment_recommendations, notes) VALUES (:child_id, :checkup_date, :weight, :height, :head_circumference, :chest_circumference, :developmental_milestones, :physical_exam, :immunization_status, :medical_history, :assessment_recommendations, :notes)");

    // Bind parameters
    $stmt->bindParam(':child_id', $child_id);
    $stmt->bindParam(':checkup_date', $checkup_date);
    $stmt->bindParam(':weight', $weight);
    $stmt->bindParam(':height', $height);
    $stmt->bindParam(':head_circumference', $head);
    $stmt->bindParam(':chest_circumference', $chest);
    $stmt->bindParam(':developmental_milestones', $developmental_milestones);
    $stmt->bindParam(':physical_exam', $physical_exam);
    $stmt->bindParam(':immunization_status', $immunization_status);
    $stmt->bindParam(':medical_history', $medical_history);
    $stmt->bindParam(':assessment_recommendations', $assessment_recommendations);
    $stmt->bindParam(':notes', $notes);
    $stmt->execute();

    header("Location: ../child_findings.php?child_id=$child_id&status=added_successfully");
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