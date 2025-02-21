<?php

include "../includes/db_connect.php";

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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Retrieve form data
  $child_id = $_POST['child_id'];
  $date = date('Y-m-d');
  $vaccine = $_POST['vaccine'];
  $dose = $_POST['dose'];
  $doc = $_POST['doc'];
  $doc_name = $_POST['pediatrician'];
  $pediatrician = $doc . ' ' . $doc_name;
  $reaction = $_POST['reaction'];
  $next_vaccine = $_POST['next_vaccine'];
  $next_appointment = $_POST['next_appointment'];
  $record_type = $_POST['record_type'];

  // Format (capitalize each word)
  $reaction = ucwords(strtolower($reaction));

  $vaccine_info = $pdo->prepare("SELECT * FROM vaccine_tbl WHERE vaccine_name = :vaccine_name");
  $vaccine_info->execute(['vaccine_name' => $vaccine]);
  $v_info = $vaccine_info->fetch(PDO::FETCH_ASSOC);
  $v_id = $v_info['vaccine_id'];
  $v_quantity = $v_info['quantity'];
  $v_quantity = $v_quantity - 1;

  // get parent info based on the child id
  $get_parent = $pdo->prepare("SELECT parent_id FROM child_tbl WHERE child_id = $child_id");
  $get_parent->execute();
  $result = $get_parent->fetch(PDO::FETCH_ASSOC);

  $u_id = $result['parent_id'];

  $get_user_info = $pdo->prepare("SELECT * FROM user_tbl WHERE user_id = $u_id");
  $get_user_info->execute();
  $result = $get_user_info->fetch(PDO::FETCH_ASSOC);

  $p_contact = $result['contact_no'];
  $p_email = $result['email'];


  try {
    // Prepare the SQL statement

    $update_vaccine = $pdo->prepare("UPDATE vaccine_tbl SET quantity = :quantity WHERE vaccine_id = :vaccine_id");

    $update_vaccine->bindParam(':vaccine_id', $v_id, PDO::PARAM_INT);
    $update_vaccine->bindParam(':quantity', $v_quantity, PDO::PARAM_INT);
    $update_vaccine->execute();

    $stmt = $pdo->prepare("INSERT INTO immunization_tbl (child_id, date, vaccine, dose, pediatrician, reaction, next_vaccine, next_appointment, record_type) VALUES (:child_id, :date, :vaccine, :dose, :pediatrician, :reaction, :next_vaccine, :next_appointment, :record_type)");

    // Bind parameters
    $stmt->bindParam(':child_id', $child_id);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':vaccine', $vaccine);
    $stmt->bindParam(':dose', $dose);
    $stmt->bindParam(':pediatrician', $pediatrician);
    $stmt->bindParam(':reaction', $reaction);
    $stmt->bindParam(':next_vaccine', $next_vaccine);
    $stmt->bindParam(':next_appointment', $next_appointment);
    $stmt->bindParam(':record_type', $record_type);
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
      $mail->addAddress($p_email, 'Recipient');    // Add a recipient

      /// Content
      $mail->isHTML(true);                                        // Set email format to HTML
      $mail->Subject = 'Next Vaccination Schedule';
      $mail->Body = "Gonzalez Aguilar Children's Clinic: Your child next vaccination schedule is on $next_appointment.";
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      // $mail->send();
      try {
        $mail->send();
        echo "Email sent successfully\n";
      } catch (Exception $e) {
        echo "Email could not be sent. Error: {$mail->ErrorInfo}\n";
      }

      // sms api
      $message = "Gonzalez Aguilar Children's Clinic: Your child next vaccination schedule is on $next_appointment.";
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
    }

    header("Location: ../child_immunization.php?child_id=$child_id&status=added_successfully");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    // header("Location: ../child_immunization.php?child_id=$child_id&status=error");
    // echo $child_id;
    // echo $date;
    // echo $vaccine;
    // echo $dose;
    // echo $pediatrician;
    // echo $reaction;
    // echo $next_appointment;
    // Handle database errors
    echo "Database error: " . $e->getMessage();
  }
}
?>