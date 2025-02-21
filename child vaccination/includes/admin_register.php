<?php

@include "db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $s_fname = $_POST['s_fname'];
    $s_m_initial = $_POST['s_m_initial'];
    $s_lname = $_POST['s_lname'];
    $pass = md5($_POST['pass']);
    $pass2 = $_POST['pass'];
    $contact_no = $_POST['contact_no'];
    $user_type = 'doctor';
    $unique_id = rand(time(), 100000000);
    $session_status = "Offline now";

    // Format (capitalize each word)
    $s_fname = ucwords(strtolower($s_fname));
    $s_lname = ucwords(strtolower($s_lname));
    $barangay = ucwords(strtolower($barangay));
    $street = ucwords(strtolower($street));
    $city = ucwords(strtolower($city));
    $s_m_initial = ucwords(strtolower($s_m_initial));

    // Function to handle file upload
    function uploadFile($file, $uploadDir)
    {
        if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $file['tmp_name'];
            $fileName = $file['name'];
            $fileSize = $file['size'];
            $fileType = $file['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // Sanitize file name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            $dest_path = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                return $dest_path;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    $uploadFileDir = '../uploads/';
    $profileImagePath = uploadFile($_FILES['staff_pic'], $uploadFileDir);

    // Debug statements
    if (!$profileImagePath) {
        error_log("Profile image upload failed: " . print_r($_FILES['staff_pic'], true));
    }

    if (!$profileImagePath) {
        header("Location: register.php?status=error_upload");
        exit();
    }

    $profile_name = '../uploads/' . basename($profileImagePath);

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("INSERT INTO staff_tbl (unique_id, s_fname, s_m_initial, s_lname, email, pass, user_type, contact_no, session_status, staff_pic) VALUES (:unique_id, :s_fname, :s_m_initial, :s_lname, :email, :pass, :user_type, :contact_no, :session_status, :staff_pic)");

        // Bind parameters
        $stmt->bindParam(':unique_id', $unique_id);
        $stmt->bindParam(':s_fname', $s_fname);
        $stmt->bindParam(':s_m_initial', $s_m_initial);
        $stmt->bindParam(':s_lname', $s_lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':user_type', $user_type);
        $stmt->bindParam(':contact_no', $contact_no);
        $stmt->bindParam(':session_status', $session_status);
        $stmt->bindParam(':staff_pic', $profile_name);

        $stmt->execute();

        header("Location: admin_login.php?status=acc_created");
        exit();

    } catch (PDOException $e) {
        // Handle database errors
        echo "Database error: " . $e->getMessage();
    }
}
?>