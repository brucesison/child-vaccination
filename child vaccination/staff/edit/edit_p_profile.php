<?php

@include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $parent_id = $_POST['user_id'];

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
        $stmt = $pdo->prepare("UPDATE user_tbl SET profile_image = :profile_image WHERE user_id = :user_id");


        // Bind parameters
        $stmt->bindParam(':user_id', $parent_id);
        $stmt->bindParam(':profile_image', $profile_name);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../view_parent.php?user_id=$parent_id&status=profile_updated");
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
