<?php

@include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $staff_id = $_POST['staff_id'];

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
            header("Location: ../view_admin.php?status=error_upload");
            exit();
        }
    } else {
        // Handle the error
        header("Location: ../view_admin.php?status=error_upload");
        exit();
    }

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("UPDATE staff_tbl SET staff_pic = :staff_pic WHERE staff_id = :staff_id");


        // Bind parameters
        $stmt->bindParam(':staff_id', $staff_id);
        $stmt->bindParam(':staff_pic', $profile_name);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../view_myprofile.php?status=profile_updated");
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