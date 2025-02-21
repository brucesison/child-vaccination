<?php

@include "db_connect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../staff/vendor_smtp/autoload.php';

require '../staff/vendor_sms/autoload.php';

// api for sms notification
use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $u_fname = $_POST['u_fname'];
    $u_m_name = $_POST['u_m_name'];
    $u_lname = $_POST['u_lname'];
    $pass = md5($_POST['pass']);
    $pass2 = $_POST['pass'];
    $contact_no = $_POST['contact_no'];
    $relationship = $_POST['relationship'];
    $barangay = $_POST['barangay'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $status = 'not-verified';
    $user_type = 'user';
    $unique_id = rand(time(), 100000000);
    $session_status = "Offline now";

    // Format (capitalize each word)
    $u_fname = ucwords(strtolower($u_fname));
    $u_lname = ucwords(strtolower($u_lname));
    $barangay = ucwords(strtolower($barangay));
    $street = ucwords(strtolower($street));
    $city = ucwords(strtolower($city));
    $u_m_name = ucwords(strtolower($u_m_name));

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
    $profileImagePath = uploadFile($_FILES['profile_image'], $uploadFileDir);
    $idFrontImagePath = uploadFile($_FILES['id_front'], $uploadFileDir);
    $idBackImagePath = uploadFile($_FILES['id_back'], $uploadFileDir);

    // Debug statements
    if (!$profileImagePath) {
        error_log("Profile image upload failed: " . print_r($_FILES['profile_image'], true));
    }
    if (!$idFrontImagePath) {
        error_log("ID front image upload failed: " . print_r($_FILES['id_front'], true));
    }
    if (!$idBackImagePath) {
        error_log("ID back image upload failed: " . print_r($_FILES['id_back'], true));
    }

    if (!$profileImagePath || !$idFrontImagePath || !$idBackImagePath) {
        header("Location: register.php?status=error_upload");
        exit();
    }

    $profile_name = '../uploads/' . basename($profileImagePath);
    $id_front_name = '../uploads/' . basename($idFrontImagePath);
    $id_back_name = '../uploads/' . basename($idBackImagePath);

    $stmt = $pdo->prepare("SELECT email FROM staff_tbl");
    $stmt->execute();
    $doctor_emails = $stmt->fetchAll(PDO::FETCH_COLUMN);


    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("INSERT INTO user_tbl (unique_id, u_fname, u_m_name, u_lname, email, pass, user_type, contact_no, relationship, barangay, street, city, state, zipcode, status, session_status, profile_image, id_front, id_back) VALUES (:unique_id, :u_fname, :u_m_name, :u_lname, :email, :pass, :user_type, :contact_no, :relationship, :barangay, :street, :city, :state, :zipcode, :status, :session_status, :profile_image, :id_front, :id_back)");

        // Bind parameters
        $stmt->bindParam(':unique_id', $unique_id);
        $stmt->bindParam(':u_fname', $u_fname);
        $stmt->bindParam(':u_m_name', $u_m_name);
        $stmt->bindParam(':u_lname', $u_lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':user_type', $user_type);
        $stmt->bindParam(':contact_no', $contact_no);
        $stmt->bindParam(':relationship', $relationship);
        $stmt->bindParam(':barangay', $barangay);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':zipcode', $zipcode);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':session_status', $session_status);
        $stmt->bindParam(':profile_image', $profile_name);
        $stmt->bindParam(':id_front', $id_front_name);
        $stmt->bindParam(':id_back', $id_back_name);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $mail = new PHPMailer(true);
            //Server settings
            $mail->SMTPDebug = 0;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = 'deng36553@gmail.com';                 // SMTP username
            $mail->Password = 'nbkq zdwh wrfv hcjq';                  // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('deng36553@gmail.com', "Children's Clinic");

            // all of doctors email will recieve email notification about new acc created
            foreach ($doctor_emails as $doctor_email) {
                $mail->addAddress($doctor_email);
            }

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = 'New User Account Created - Review and Verification Needed';
            $mail->Body = 'Please take a moment to review the information and verify the new user account. Your timely action is crucial to maintaining the integrity and security of our platform.';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            // $mail->send();
            try {
                $mail->send();
                echo "Email sent successfully\n";
            } catch (Exception $e) {
                echo "Email could not be sent. Error: {$mail->ErrorInfo}\n";
            }

            // parent email account credentials notification
            $mail2 = new PHPMailer(true);
            $mail2->SMTPDebug = 0;                                       // Enable verbose debug output
            $mail2->isSMTP();                                            // Set mailer to use SMTP
            $mail2->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
            $mail2->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail2->Username = 'deng36553@gmail.com';                 // SMTP username
            $mail2->Password = 'nbkq zdwh wrfv hcjq';                  // SMTP password
            $mail2->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail2->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail2->setFrom('deng36553@gmail.com', "Children's Clinic");
            $mail2->addAddress($email, 'Recipient');

            // Content
            $mail2->isHTML(true);                                        // Set email format to HTML
            $mail2->Subject = 'Account Registered';
            $mail2->Body = "Your account has been registered!<br>Account info:<br>Email: $email<br>Password: $pass2";
            $mail2->AltBody = 'This is the body in plain text for non-HTML mail clients';

            // $mail2->send();
            try {
                $mail2->send();
                echo "Email sent successfully\n";
            } catch (Exception $e) {
                echo "Email could not be sent. Error: {$mail->ErrorInfo}\n";
            }

            // // sms api
            $message = "Your account has been registered! \n\nAccount info:\n\nEmail: $email\n\nPassword: $pass2";
            $phoneNumber = "+63$contact_no";

            $apiURL = "1ggd1n.api.infobip.com";
            $apiKey = "301a9682e386209301eb2ad8ed2c6167-7ed08f95-df45-4626-b294-b8dccd301d95";

            $configuration = new Configuration(host: $apiURL, apiKey: $apiKey);
            $api = new SmsApi(config: $configuration);

            $destination = new SmsDestination(to: $phoneNumber);

            $theMessage = new SmsTextualMessage(
                destinations: [$destination],
                text: $message,
                from: "Doc Bruce"
            );

            // send sms message
            $request = new SmsAdvancedTextualRequest(messages: [$theMessage]);
            // $response = $api->sendSmsMessage($request);
            try {
                $response = $api->sendSmsMessage($request);
                echo "SMS sent successfully\n";
            } catch (Exception $e) {
                echo "SMS could not be sent. Error: {$e->getMessage()}\n";
            }
            // // end of api
        }

        header("Location: parent_login.php?status=acc_created");
        exit();

    } catch (PDOException $e) {
        // Handle database errors
        echo "Database error: " . $e->getMessage();
    }
}
?>