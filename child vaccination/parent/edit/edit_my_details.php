<?php

@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $parent_id = $_POST['user_id'];
  $u_fname = $_POST['u_fname'];
  $u_m_name = $_POST['u_m_name'];
  $u_lname = $_POST['u_lname'];
  $contact_no = $_POST['contact_no'];
  $email = $_POST['email'];
  $barangay = $_POST['barangay'];
  $street = $_POST['street'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $zipcode = $_POST['zipcode'];
  $relationship = $_POST['relationship'];

  // Format (capitalize each word)
  $u_fname = ucwords(strtolower($u_fname));
  $u_lname = ucwords(strtolower($u_lname));
  $barangay = ucwords(strtolower($barangay));
  $street = ucwords(strtolower($street));
  $city = ucwords(strtolower($city));
  $state = ucwords(strtolower($state));
  $u_m_name = ucwords(strtolower($u_m_name));
  $relationship = ucwords(strtolower($relationship));

  try {
    $stmt = $pdo->prepare("UPDATE user_tbl SET u_fname = :u_fname, u_m_name = :u_m_name, u_lname = :u_lname, contact_no = :contact_no, email = :email, city = :city, barangay = :barangay, street = :street, state = :state, zipcode = :zipcode, relationship = :relationship WHERE user_id = :user_id");

    $stmt->bindParam(':user_id', $parent_id);
    $stmt->bindParam(':u_fname', $u_fname);
    $stmt->bindParam(':u_m_name', $u_m_name);
    $stmt->bindParam(':u_lname', $u_lname);
    $stmt->bindParam(':contact_no', $contact_no);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':barangay', $barangay);
    $stmt->bindParam(':street', $street);
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':zipcode', $zipcode);
    $stmt->bindParam(':relationship', $relationship);
    $stmt->execute();

    header("Location: ../view_my_profile.php?status=details_updated");
    exit();
  } catch (PDOException $e) {
    header("Location: ../view_my_profile.php?status=error");
    exit();
  }
}

?>