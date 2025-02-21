<?php

@include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $u_fname = $_POST['u_fname'];
    $u_m_name = $_POST['u_m_name'];
    $u_lname = $_POST['u_lname'];
    $email = $_POST['email'];
    $pass = md5($_POST['pass']);
    $contact_no = $_POST['contact_no'];
    $barangay = $_POST['barangay'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $status = 'verified';
    $user_type = 'user';
    $unique_id = rand(time(), 100000000);
    $session_status = "Offline now";
    $relationship = $_POST['relationship'];
    $id_front = "N/A";
    $id_back = "N/A";

    // Format (capitalize each word)
    $u_fname = ucwords(strtolower($u_fname));
    $u_lname = ucwords(strtolower($u_lname));
    $barangay = ucwords(strtolower($barangay));
    $street = ucwords(strtolower($street));
    $city = ucwords(strtolower($city));
    $state = ucwords(strtolower($state));
    $u_m_name = ucwords(strtolower($u_m_name));
    $relationship = ucwords(strtolower($relationship));

    // Handle file upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileSize = $_FILES['profile_image']['size'];
        $fileType = $_FILES['profile_image']['type'];
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
            header("Location: ../list_parent.php?status=error_upload");
            exit();
        }
    } else {
        // Handle the error
        header("Location: ../list_parent.php?status=error_upload");
        exit();
    }

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("INSERT INTO user_tbl (unique_id, u_fname, u_m_name, u_lname, email, pass, user_type, contact_no, barangay, street, city, state, zipcode, status, session_status, relationship, profile_image, id_front, id_back) VALUES (:unique_id, :u_fname, :u_m_name, :u_lname, :email, :pass, :user_type, :contact_no, :barangay, :street, :city, :state, :zipcode, :status, :session_status, :relationship, :profile_image, :id_front, :id_back)");

        // Bind parameters
        $stmt->bindParam(':unique_id', $unique_id);
        $stmt->bindParam(':u_fname', $u_fname);
        $stmt->bindParam(':u_m_name', $u_m_name);
        $stmt->bindParam(':u_lname', $u_lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':user_type', $user_type);
        $stmt->bindParam(':contact_no', $contact_no);
        $stmt->bindParam(':barangay', $barangay);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':zipcode', $zipcode);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':session_status', $session_status);
        $stmt->bindParam(':relationship', $relationship);
        $stmt->bindParam(':profile_image', $profile_name);
        $stmt->bindParam(':id_front', $id_front);
        $stmt->bindParam(':id_back', $id_back);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../list_parent_table.php?form_status=added_successfully");
            exit();
        } else {
            // Output the error for debugging
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo "Database error: " . $e->getMessage();
    }
}
?>