<?php

// Database connection parameters
@include '../includes/db_connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor_smtp/autoload.php';

// require '../vendor_sms/autoload.php';

// // api for sms notification
// use Infobip\Configuration;
// use Infobip\Api\SmsApi;
// use Infobip\Model\SmsDestination;
// use Infobip\Model\SmsTextualMessage;
// use Infobip\Model\SmsAdvancedTextualRequest;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $parent_id = $_POST["parent_id"];
  $appointment_id = $_POST["appointment_id"];
  $appointment_date = $_POST["appointment_date"];
  $status = $_POST["status"];
  $reason = $_POST["reject_reason"];

  $stmt = $pdo->prepare("SELECT email FROM user_tbl WHERE user_id = $parent_id");
  $stmt->execute();
  $email = $stmt->fetch(PDO::FETCH_ASSOC);
  $parent_email = $email['email'];

  try {
    $stmt = $pdo->prepare("UPDATE appointment_tbl SET status = :status , reject_reason = :reject_reason WHERE appointment_id = :appointment_id");
    $stmt->bindParam(':appointment_id', $appointment_id);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':reject_reason', $reason);
    $stmt->execute();

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
    $mail->addAddress($parent_email, 'Recipient');    // Add a recipient

    // Content
    $mail->isHTML(true);                                        // Set email format to HTML
    $mail->Subject = 'Appointment Rejected';
    $mail->Body = "Hi, this is Gonzalez Aguilar Children's Clinic. Your appointment was rejected. Reason: $reason";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    // $mail->send();

    try {
      $mail->send();
      echo "Email sent successfully\n";
    } catch (Exception $e) {
      echo "Email could not be sent. Error: {$mail->ErrorInfo}\n";
    }

    // // sms api

    // $stmt = $pdo->prepare("SELECT * FROM user_tbl WHERE user_id = $parent_id");
    // $stmt->execute();
    // $req = $stmt->fetch(PDO::FETCH_ASSOC);

    // $p_contact = $req['contact_no'];

    // // $message = "Hi this is Gonzalez Aguilar Children's Clinic. Sorry we need to reject your appointment. Reason: $reason";
    // $message = "Hi, this is Gonzalez Aguilar Children's Clinic. Your appointment was rejected. Reason: $reason";
    // $phoneNumber = "+63$p_contact";

    // $apiURL = "1ggd1n.api.infobip.com";
    // $apiKey = "301a9682e386209301eb2ad8ed2c6167-7ed08f95-df45-4626-b294-b8dccd301d95";

    // $configuration = new Configuration(host: $apiURL, apiKey: $apiKey);
    // $api = new SmsApi(config: $configuration);

    // $destination = new SmsDestination(to: $phoneNumber);

    // $theMessage = new SmsTextualMessage(
    //   destinations: [$destination],
    //   text: $message,
    //   from: "Bruce"
    // );

    // // send sms message
    // $request = new SmsAdvancedTextualRequest(messages: [$theMessage]);
    // // $response = $api->sendSmsMessage($request);
    // try {
    //   $response = $api->sendSmsMessage($request);
    //   echo "SMS sent successfully\n";
    // } catch (Exception $e) {
    //   echo "SMS could not be sent. Error: {$e->getMessage()}\n";
    // }
    // // end of api

    header("Location: ../app_request.php?status=rejected");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    // header("Location: ../app_request.php?status=error");
    // exit();
    echo "Database error: " . $e->getMessage();

  }

}
?>