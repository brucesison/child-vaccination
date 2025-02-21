<?php

// Database connection parameters
@include '../includes/db_connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor_smtp/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $parent_name = $_POST["parent_name"];
  $appointment_date = $_POST["appointment_date"];
  $appointment_id = $_POST["appointment_id"];
  $status = $_POST["status"];
  $cancel_reason = $_POST["cancel_reason"];

  $stmt = $pdo->prepare("SELECT email FROM staff_tbl");
  $stmt->execute();
  $staff_emails = $stmt->fetchAll(PDO::FETCH_COLUMN);

  try {
    $stmt = $pdo->prepare("UPDATE appointment_tbl SET status = :status, cancel_reason = :cancel_reason WHERE appointment_id = :appointment_id");
    $stmt->bindParam(':appointment_id', $appointment_id);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':cancel_reason', $cancel_reason);
    $stmt->execute();

    $mail = new PHPMailer(true);
    // Server settings
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

    // all of doctors emails will recieve email notification
    foreach ($staff_emails as $staff_email) {
      $mail->addAddress($staff_email);
    }

    // Content
    $mail->isHTML(true);                                        // Set email format to HTML
    $mail->Subject = 'Appointment Cancelled';
    $mail->Body = "$parent_name cancel appointment on $appointment_date. Reason: $cancel_reason";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    // $mail->send();

    try {
      $mail->send();
      echo "Email sent successfully\n";
    } catch (Exception $e) {
      echo "Email could not be sent. Error: {$mail->ErrorInfo}\n";
    }


    header("Location: ../index.php?status=cancelled");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    header("Location: ../index.php?status=error");
    exit();
  }

}
?>