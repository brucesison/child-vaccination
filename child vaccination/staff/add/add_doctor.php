<?php

@include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Retrieve form data
  $s_fname = $_POST['s_fname'];
  $s_m_initial = $_POST['s_m_initial'];
  $s_lname = $_POST['s_lname'];
  $email = $_POST['email'];
  $pass = md5($_POST['pass']);
  $contact_no = $_POST['contact_no'];
  $user_type = "doctor";
  $unique_id = rand(time(), 100000000);
  $session_status = "Offline now";

  // Format (capitalize each word)
  $s_fname = ucwords(strtolower($s_fname));
  $s_lname = ucwords(strtolower($s_lname));
  $s_m_initial = ucwords(strtolower($s_m_initial));

  // Handle file upload
  if (isset($_FILES['staff_pic']) && $_FILES['staff_pic']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['staff_pic']['tmp_name'];
    $fileName = $_FILES['staff_pic']['name'];
    $fileSize = $_FILES['staff_pic']['size'];
    $fileType = $_FILES['staff_pic']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // Sanitize file name
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

    // Directory where uploaded files will be saved
    $uploadFileDir = '../../uploads/';
    $dest_path = $uploadFileDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $dest_path)) {
      $profileImagePath = $dest_path;
      $profile_name = '../uploads/' . $newFileName;
    } else {
      // Handle the error
      header("Location: ../admins.php?status=error_upload");
      exit();
    }
  } else {
    // Handle the error
    header("Location: ../admins.php?status=error_upload");
    exit();
  }

  try {
    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO staff_tbl (unique_id, s_fname, s_m_initial, s_lname, email, pass, contact_no,staff_pic, user_type, session_status) VALUES (:unique_id, :s_fname, :s_m_initial, :s_lname, :email, :pass, :contact_no, :staff_pic, :user_type, :session_status)");

    // Bind parameters
    $stmt->bindParam(':unique_id', $unique_id);
    $stmt->bindParam(':s_fname', $s_fname);
    $stmt->bindParam(':s_m_initial', $s_m_initial);
    $stmt->bindParam(':s_lname', $s_lname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pass', $pass);
    $stmt->bindParam(':contact_no', $contact_no);
    $stmt->bindParam(':staff_pic', $profile_name);
    $stmt->bindParam(':user_type', $user_type);
    $stmt->bindParam(':session_status', $session_status);
    $stmt->execute();

    header("Location: ../admins.php?status=added_successfully");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    // header("Location: ../admins.php?status=error");
    echo "Database error: " . $e->getMessage();
  }
}
?>