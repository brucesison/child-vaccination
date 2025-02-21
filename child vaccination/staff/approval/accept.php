<?php

// Database connection parameters
include '../includes/db_connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor_smtp/autoload.php';


require '../vendor_sms/autoload.php';

// api for sms notification
use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $parent_id = $_POST["parent_id"];
  $appointment_id = $_POST["appointment_id"];
  $appointment_date = $_POST["appointment_date"];
  $status = $_POST["status"];

  $appointment_time = $_POST["appointment_time"];

  $app_time = json_decode($appointment_time, true);
  if (!empty($app_time) && is_array($app_time)) {
    // Sort the time slots
    sort($app_time);

    // Get the start time (first element)
    $start_time = $app_time[0];

    // Calculate the end time (last element + 30 minutes)
    $end_time = end($app_time);
    $end_time_datetime = DateTime::createFromFormat('h:i A', $end_time);
    $end_time_datetime->add(new DateInterval('PT30M'));
    $formatted_end_time = $end_time_datetime->format('h:i A');

    // Display the time range
    $time_range = htmlspecialchars($start_time) . " to " . htmlspecialchars($formatted_end_time);
    if ($time_range == '10:00 AM to 10:00 AM') {
      $time_range = '9:30 AM to 10:30 AM';
    }
  }

  $stmt = $pdo->prepare("SELECT email FROM user_tbl WHERE user_id = $parent_id");
  $stmt->execute();
  $email = $stmt->fetch(PDO::FETCH_ASSOC);
  $parent_email = $email['email'];



  try {
    $stmt = $pdo->prepare("UPDATE appointment_tbl SET status = :status WHERE appointment_id = :appointment_id");
    $stmt->bindParam(':appointment_id', $appointment_id);
    $stmt->bindParam(':status', $status);
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
    $mail->addAddress($parent_email, 'Recipient');    // Add a recipient

    // Content
    $mail->isHTML(true);                                        // Set email format to HTML
    $mail->Subject = 'Appointment Accepted';
    $mail->Body = "Your appointment on $appointment_date from $time_range has been accepted. Please arrive at the clinic 10 minutes before your scheduled time. Thank you!";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    // $mail->send();

    try {
      $mail->send();
      echo "Email sent successfully\n";
    } catch (Exception $e) {
      echo "Email could not be sent. Error: {$mail->ErrorInfo}\n";
    }

    // sms api

    $stmt = $pdo->prepare("SELECT * FROM user_tbl WHERE user_id = $parent_id");
    $stmt->execute();
    $req = $stmt->fetch(PDO::FETCH_ASSOC);

    $p_contact = $req['contact_no'];

    $clinic_name = "Gonzalez Aguilar Children's Clinic";

    // $message = "Your appointment on $appointment_date , $time  is now accepted Please go to clinic 30mins before your appointment. Thank you!";
    $message = "Your appointment on $appointment_date from $time_range has been accepted. Please arrive at the clinic 10 minutes before your scheduled time. Thank you!";
    $phoneNumber = "+63$p_contact";

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
    // end of api

    header("Location: ../app_request.php?status=accepted");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    header("Location: ../app_request.php?status=error");
    exit();
  }

}
?>