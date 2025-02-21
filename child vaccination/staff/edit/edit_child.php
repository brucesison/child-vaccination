<?php

@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $child_id = $_POST["child_id"];

  $c_fname = $_POST['c_fname'];
  $c_m_name = $_POST['c_m_name'];
  $c_lname = $_POST['c_lname'];
  $birth_date = $_POST["birth_date"];
  $birth_time = $_POST["birth_time"];
  $gender = $_POST["gender"];

  $m_fname = $_POST['m_fname'];
  $m_m_name = $_POST['m_m_name'];
  $m_lname = $_POST['m_lname'];

  $f_fname = $_POST['f_fname'];
  $f_m_name = $_POST['f_m_name'];
  $f_lname = $_POST['f_lname'];

  $g_fname = $_POST['g_fname'];
  $g_m_name = $_POST['g_m_name'];
  $g_lname = $_POST['g_lname'];

  $guardian_name = $_POST["guardian_name"];
  $mother_contact = $_POST["mother_contact"];
  $father_contact = $_POST["father_contact"];
  $guardian_contact = $_POST["guardian_contact"];
  $hospital = $_POST["hospital"];

  $obs = $_POST["obs"];
  $pedia = $_POST["pedia"];
  $obs_name = $_POST["obstretician"];
  $pedia_name = $_POST["pediatrician"];

  $obstretician = $obs . ' ' . $obs_name;

  if ($pedia_name == 'N/A') {
    $pediatrician = $_POST["pediatrician"];
  } else {
    $pediatrician = $pedia . ' ' . $pedia_name;
    $pediatrician = ucwords(strtolower($pediatrician));
  }

  $type_of_delivery = $_POST["type_of_delivery"];
  $weight = $_POST["weight"];
  $height = $_POST["height"];
  $head = $_POST["head"];
  $chest = $_POST["chest"];
  $apgar = $_POST["apgar"];
  $blood_type = $_POST["blood_type"];
  $eye_color = $_POST["eye_color"];
  $hair_color = $_POST["hair_color"];
  $marks = $_POST["marks"];

  // Format (capitalize each word)
  $c_fname = ucwords(strtolower($c_fname));
  $c_lname = ucwords(strtolower($c_lname));
  $m_fname = ucwords(strtolower($m_fname));
  $m_lname = ucwords(strtolower($m_lname));
  $f_fname = ucwords(strtolower($f_fname));
  $f_lname = ucwords(strtolower($f_lname));
  $g_fname = ucwords(strtolower($g_fname));
  $c_m_name = ucwords(strtolower($c_m_name));
  $m_m_name = ucwords(strtolower($m_m_name));
  $f_m_name = ucwords(strtolower($f_m_name));
  $g_m_name = ucwords(strtolower($g_m_name));
  $obstretician = ucwords(strtolower($obstretician));
  $hospital = ucwords(strtolower($hospital));
  $type_of_delivery = ucwords(strtolower($type_of_delivery));
  $eye_color = ucwords(strtolower($eye_color));
  $hair_color = ucwords(strtolower($hair_color));
  $marks = ucwords(strtolower($marks));

  try {
    $stmt = $pdo->prepare("UPDATE child_tbl SET c_fname = :c_fname, c_m_name = :c_m_name, c_lname = :c_lname, m_fname = :m_fname, m_m_name = :m_m_name, m_lname = :m_lname, f_fname = :f_fname, f_m_name = :f_m_name, f_lname = :f_lname, g_fname = :g_fname, g_m_name = :g_m_name, g_lname = :g_lname, gender = :gender, birth_date = :birth_date, birth_time = :birth_time, mother_contact = :mother_contact, father_contact = :father_contact, guardian_contact = :guardian_contact, hospital = :hospital, obstretician = :obstretician, pediatrician = :pediatrician, type_of_delivery = :type_of_delivery, weight = :weight, height = :height, head = :head, chest = :chest, apgar = :apgar, blood_type = :blood_type, eye_color = :eye_color, hair_color = :hair_color, marks = :marks WHERE child_id = :child_id");

    $stmt->bindParam(':c_fname', $c_fname);
    $stmt->bindParam(':c_m_name', $c_m_name);
    $stmt->bindParam(':c_lname', $c_lname);
    $stmt->bindParam(':m_fname', $m_fname);
    $stmt->bindParam(':m_m_name', $m_m_name);
    $stmt->bindParam(':m_lname', $m_lname);
    $stmt->bindParam(':f_fname', $f_fname);
    $stmt->bindParam(':f_m_name', $f_m_name);
    $stmt->bindParam(':f_lname', $f_lname);
    $stmt->bindParam(':g_fname', $g_fname);
    $stmt->bindParam(':g_m_name', $g_m_name);
    $stmt->bindParam(':g_lname', $g_lname);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':birth_date', $birth_date);
    $stmt->bindParam(':birth_time', $birth_time);
    $stmt->bindParam(':mother_contact', $mother_contact);
    $stmt->bindParam(':father_contact', $father_contact);
    $stmt->bindParam(':guardian_contact', $guardian_contact);
    $stmt->bindParam(':hospital', $hospital);
    $stmt->bindParam(':obstretician', $obstretician);
    $stmt->bindParam(':pediatrician', $pediatrician);
    $stmt->bindParam(':type_of_delivery', $type_of_delivery);
    $stmt->bindParam(':weight', $weight);
    $stmt->bindParam(':height', $height);
    $stmt->bindParam(':head', $head);
    $stmt->bindParam(':chest', $chest);
    $stmt->bindParam(':apgar', $apgar);
    $stmt->bindParam(':blood_type', $blood_type);
    $stmt->bindParam(':eye_color', $eye_color);
    $stmt->bindParam(':hair_color', $hair_color);
    $stmt->bindParam(':marks', $marks);
    $stmt->bindParam(':child_id', $child_id);

    $stmt->execute();

    header("Location: ../view_child.php?child_id=$child_id&status=child_updated");
    exit();
  } catch (PDOException $e) {
    header("Location: ../view_child.php?child_id=$child_id&status=error");
    exit();
  }
}
?>