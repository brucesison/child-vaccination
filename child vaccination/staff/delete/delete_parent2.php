<?php

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $parent_id = $_POST["parent_id"];
  $p_contact = $_POST["contact_no"];
  $parent_email = $_POST["email"];
  $deletion_reason = $_POST["deletion_reason"];

  $stmt = $pdo->prepare("SELECT * FROM child_tbl WHERE parent_id = $parent_id");
  $stmt->execute();
  $child = $stmt->fetchAll(PDO::FETCH_ASSOC);

  try {

    if (!empty($child)) {
      foreach ($child as $children) {
        $child_id = $children['child_id'];

        $stmt = $pdo->prepare("DELETE FROM immunization_tbl WHERE child_id = :child_id");
        $stmt->bindParam(':child_id', $child_id);
        $stmt->execute();

        $stmt = $pdo->prepare("DELETE FROM checkup_findings_tbl WHERE child_id = :child_id");
        $stmt->bindParam(':child_id', $child_id);
        $stmt->execute();

        $stmt = $pdo->prepare("DELETE FROM child_tbl WHERE child_id = :child_id");
        $stmt->bindParam(':child_id', $child_id);
        $stmt->execute();
      }
    }

    $stmt = $pdo->prepare("DELETE FROM appointment_tbl WHERE parent_id = :parent_id");
    $stmt->bindParam(':parent_id', $parent_id);
    $stmt->execute();

    // Now delete parent
    $stmt = $pdo->prepare("DELETE FROM user_tbl WHERE user_id = :parent_id");
    $stmt->bindParam(':parent_id', $parent_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {

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
      $mail->Subject = 'Account Deletion Notice';
      $mail->Body = "Sorry we need to delete your account for the reason: $deletion_reason";
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      // $mail->send();
      try {
        $mail->send();
        echo "Email sent successfully\n";
      } catch (Exception $e) {
        echo "Email could not be sent. Error: {$mail->ErrorInfo}\n";
      }

      // sms api
      $message = "Gonzalez Aguilar Children's Clinic: Sorry we need to delete your account for the  reason: $deletion_reason";
      $phoneNumber = "+63$p_contact";

      $apiURL = "xlzdze.api.infobip.com";
      $apiKey = "2a0d9a5c67ee6a5f6d39f09fe3333eba-084b495d-c511-4efd-a41d-a746871f93b5";

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
    }

    header("Location: ../list_parent_table.php?form_status=deleted_successfully");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    // header("Location: ../list_parent.php?status=error");
    echo "Database error: " . $e->getMessage();
    exit();
  }
}


?>