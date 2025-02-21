<?php

// Database connection parameters
include '../includes/db_connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor_smtp/autoload.php';

// require '../vendor_sms/autoload.php';

// api for sms notification
// use Infobip\Configuration;
// use Infobip\Api\SmsApi;
// use Infobip\Model\SmsDestination;
// use Infobip\Model\SmsTextualMessage;
// use Infobip\Model\SmsAdvancedTextualRequest;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $p_email = $_POST["email"];
  $p_contact = $_POST["contact_no"];
  $user_id = $_POST["user_id"];
  $status = $_POST["status"];

  $mail = new PHPMailer(true);

  try {
    $stmt = $pdo->prepare("UPDATE user_tbl SET status = :status WHERE user_id = :user_id");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
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
      $mail->addAddress($p_email, 'Recipient');    // Add a recipient

      /// Content
      $mail->isHTML(true);                                        // Set email format to HTML
      $mail->Subject = 'Account Verified';
      $mail->Body = 'Hi, your account is now verified you can now request an appointment.';
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      // $mail->send();

      try {
        $mail->send();
        echo "Email sent successfully\n";
      } catch (Exception $e) {
        echo "Email could not be sent. Error: {$mail->ErrorInfo}\n";
      }

      // // sms api
      // $message = "Gonzalez Aguilar Children's Clinic: Hi, your account is now verified you can now request an appointment.";
      // $phoneNumber = "+63$p_contact";

      // $apiURL = "1ggd1n.api.infobip.com";
      // $apiKey = "301a9682e386209301eb2ad8ed2c6167-7ed08f95-df45-4626-b294-b8dccd301d95";

      // $configuration = new Configuration(host: $apiURL, apiKey: $apiKey);
      // $api = new SmsApi(config: $configuration);

      // $destination = new SmsDestination(to: $phoneNumber);

      // $theMessage = new SmsTextualMessage(
      //   destinations: [$destination],
      //   text: $message,
      //   from: "Doc Bruce"
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
    }

    header("Location: ../view_parent.php?user_id=$user_id&acc_status=verified");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    header("Location: ../list_parent.php?status=error");
    exit();
  }

}

?>