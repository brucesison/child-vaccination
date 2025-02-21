<?php

@include '../includes/db_connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor_smtp/autoload.php';

session_start();
$parent_id = $_SESSION["parent_id"];


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $child_name = isset($_POST['child_name']) ? json_encode($_POST['child_name']) : null;
    $appointment_date = $_POST["appointment_date"];
    $appointment_time = isset($_POST['appointment_time']) ? json_encode($_POST['appointment_time']) : null;
    $guardian_name = $_POST["guardian_name"];
    $reason_for = isset($_POST['reason_for_visit']) ? json_encode($_POST['reason_for_visit']) : null;
    $status = $_POST["status"];
    $time_requested = date('H:i:s');
    $date_requested = date('Y-m-d');
    $resched_reason = "N/A";
    $reject_reason = "N/A";
    $cancel_reason = "N/A";

    $stmt = $pdo->prepare("SELECT email FROM staff_tbl");
    $stmt->execute();
    $staff_emails = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $mail = new PHPMailer(true);
    try {
        // Prepare the SQL statement   
        $stmt = $pdo->prepare("INSERT INTO appointment_tbl (parent_id, child_name, appointment_date, appointment_time, guardian_name, reason_for_visit, status, date_requested, time_requested, resched_reason, reject_reason, cancel_reason) VALUES (:parent_id, :child_name, :appointment_date, :appointment_time, :guardian_name, :reason_for_visit, :status, :date_requested, :time_requested, :resched_reason, :reject_reason, :cancel_reason)");

        // Bind parameters
        $stmt->bindParam(':parent_id', $parent_id);
        $stmt->bindParam(':child_name', $child_name);
        $stmt->bindParam(':appointment_date', $appointment_date);
        $stmt->bindParam(':appointment_time', $appointment_time);
        $stmt->bindParam(':guardian_name', $guardian_name);
        $stmt->bindParam(':reason_for_visit', $reason_for);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':date_requested', $date_requested);
        $stmt->bindParam(':time_requested', $time_requested);
        $stmt->bindParam(':resched_reason', $resched_reason);
        $stmt->bindParam(':reject_reason', $reject_reason);
        $stmt->bindParam(':cancel_reason', $cancel_reason);

        $stmt->execute();

        // Server settings
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'deng36553@gmail.com';                 // SMTP username
        $mail->Password = 'nbkq zdwh wrfv hcjq';                  // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        // Recipients
        $mail->setFrom('deng36553@gmail.com', "Children's Clinic");

        // all of staff emails will recieve email notification
        foreach ($staff_emails as $staff_email) {
            $mail->addAddress($staff_email);
        }

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = 'New Appointment Request';
        $mail->Body = "$guardian_name request an appointment on $appointment_date";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        // $mail->send();
        try {
            $mail->send();
            echo "Email sent successfully\n";
        } catch (Exception $e) {
            echo "Email could not be sent. Error: {$mail->ErrorInfo}\n";
        }

        header("Location: ../app_request.php?status=success");
        exit();
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    header("Location: index.php");
    exit();
}
?>