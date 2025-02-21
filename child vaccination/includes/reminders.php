<?php
// Include database connection
@include 'db_connect.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer
require 'vendor/autoload.php';

// Get the date of the next day
$next_day = date('Y-m-d', strtotime('+1 day'));

// Query to select appointments scheduled for the next day
$stmt = $pdo->prepare("SELECT * FROM appointment_tbl WHERE appointment_date = :next_day");
$stmt->bindParam(':next_day', $next_day);
$stmt->execute();
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($appointments as $appointment) {
  $parent_id = $appointment['parent_id'];

  $stmt2 = $pdo->prepare("SELECT email FROM user_tbl WHERE user_id = :parent_id");
  $stmt2->bindParam(':parent_id', $parent_id);
  $stmt2->execute();
  $parent_email = $stmt2->fetch(PDO::FETCH_ASSOC);
  $email = $parent_email['email'];

  $guardian_name = $appointment['guardian_name'];
  $appointment_date = $appointment['appointment_date'];

  $app_time = json_decode($appointment['appointment_time'], true);
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
    $time = htmlspecialchars($start_time) . " to " . htmlspecialchars($formatted_end_time);
  }

  // Create a new PHPMailer instance
  $mail = new PHPMailer(true);

  try {
    // Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'deng36553@gmail.com'; // Your SMTP username
    $mail->Password = 'nbkq zdwh wrfv hcjq'; // Your SMTP password or app password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('deng36553@gmail.com', "Clinic Notification");
    $mail->addAddress($email, 'Recipient');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Appointment Reminder';
    $mail->Body = "<h2>Appointment Reminder</h2>
                       <p>Dear $guardian_name,</p>
                       <p>This is a reminder that you have an appointment scheduled for $appointment_date at $time.</p>
                       <p>Please make sure to arrive on time.</p>
                       <p>Thank you!</p>";
    $mail->AltBody = "Dear $guardian_name,\n\nThis is a reminder that you have an appointment scheduled for $appointment_date at $time.\n\nPlease make sure to arrive on time.\n\nThank you!";

    $mail->send();
    echo 'Reminder email sent to ' . $email . PHP_EOL;
  } catch (Exception $e) {
    echo "Message could not be sent to $email. Mailer Error: {$mail->ErrorInfo}" . PHP_EOL;
  }
}
?>