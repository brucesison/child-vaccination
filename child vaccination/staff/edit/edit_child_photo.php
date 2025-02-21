<?php

@include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $child_id = $_POST['child_id'];

    // Handle file upload
    if (isset($_FILES['child_pic']) && $_FILES['child_pic']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['child_pic']['tmp_name'];
        $fileName = $_FILES['child_pic']['name'];
        $fileSize = $_FILES['child_pic']['size'];
        $fileType = $_FILES['child_pic']['type'];
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
            header("Location: ../view_child.php?status=error_upload");
            exit();
        }
    } else {
        // Handle the error
        header("Location: ../view_child.php?status=error_upload");
        exit();
    }

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("UPDATE child_tbl SET child_pic = :child_pic WHERE child_id = :child_id");


        // Bind parameters
        $stmt->bindParam(':child_id', $child_id);
        $stmt->bindParam(':child_pic', $profile_name);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../view_child.php?child_id=$child_id&status=image_updated");
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
