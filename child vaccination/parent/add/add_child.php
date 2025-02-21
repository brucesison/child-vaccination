<?php

@include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $parent_id = $_POST["parent_id"];
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
    $g_lname = ucwords(strtolower($g_lname));
    $obstretician = ucwords(strtolower($obstretician));
    $hospital = ucwords(strtolower($hospital));
    $type_of_delivery = ucwords(strtolower($type_of_delivery));
    $eye_color = ucwords(strtolower($eye_color));
    $hair_color = ucwords(strtolower($hair_color));
    $marks = ucwords(strtolower($marks));

    $c_m_name = ucwords(strtolower($c_m_name));
    $m_m_name = ucwords(strtolower($m_m_name));
    $f_m_name = ucwords(strtolower($f_m_name));
    $g_m_name = ucwords(strtolower($g_m_name));

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
            header("Location: ../my_child.php?status=error_upload");
            exit();
        }
    } else {
        // Handle the error
        header("Location: ../my_child.php?status=error_upload");
        exit();
    }

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("INSERT INTO child_tbl (parent_id, c_fname, c_m_name, c_lname, birth_date, birth_time,gender, m_fname, m_m_name, m_lname, f_fname, f_m_name, f_lname,
        g_fname, g_m_name, g_lname, mother_contact, father_contact, guardian_contact, hospital, obstretician, pediatrician, type_of_delivery, weight, height, head, chest, apgar, blood_type, eye_color, hair_color, marks, child_pic) VALUES (:parent_id, :c_fname, :c_m_name, :c_lname, :birth_date, :birth_time, :gender, :m_fname, :m_m_name, :m_lname, :f_fname, :f_m_name, :f_lname, :g_fname, :g_m_name, :g_lname, :mother_contact, :father_contact, :guardian_contact, :hospital, :obstretician, :pediatrician, :type_of_delivery, :weight, :height, :head, :chest, :apgar, :blood_type, :eye_color, :hair_color, :marks, :child_pic)");


        // Bind parameters
        $stmt->bindParam(':parent_id', $parent_id);
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
        $stmt->bindParam(':birth_date', $birth_date);
        $stmt->bindParam(':birth_time', $birth_time);
        $stmt->bindParam(':gender', $gender);
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
        $stmt->bindParam(':child_pic', $profile_name);
        $stmt->execute();

        header("Location: ../my_child.php?status=success");
        exit();
    } catch (PDOException $e) {
        // Handle database errors
        // header("Location: ../my_child.php?status=error");
        echo "Database error: " . $e->getMessage();
    }
}
?>