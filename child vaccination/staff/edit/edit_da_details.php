<?php

@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $staff_id = $_POST['staff_id'];
  $contact_no = $_POST['contact_no'];
  $email = $_POST['email'];
  $s_fname = $_POST['s_fname'];
  $s_m_initial = $_POST['s_m_initial'];
  $s_lname = $_POST['s_lname'];

  // Format (capitalize each word)
  $s_fname = ucwords(strtolower($s_fname));
  $s_lname = ucwords(strtolower($s_lname));
  $s_m_initial = ucwords(strtolower($s_m_initial));

  try {
    $stmt = $pdo->prepare("UPDATE staff_tbl SET s_fname = :s_fname, s_m_initial = :s_m_initial, s_lname = :s_lname, contact_no = :contact_no, email = :email WHERE staff_id = :staff_id");

    $stmt->bindParam(':staff_id', $staff_id);
    $stmt->bindParam(':s_fname', $s_fname);
    $stmt->bindParam(':s_m_initial', $s_m_initial);
    $stmt->bindParam(':s_lname', $s_lname);
    $stmt->bindParam(':contact_no', $contact_no);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    header("Location: ../view_admin_doctor.php?staff_id=$staff_id&status=details_updated");
    exit();
  } catch (PDOException $e) {
    // header("Location: ../view_admin.php");
    // exit();
    echo "Database error: " . $e->getMessage();

  }
}

?>