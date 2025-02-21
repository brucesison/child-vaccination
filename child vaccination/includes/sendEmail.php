<?php

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer
require '../parent/vendor_smtp/autoload.php';

$p_email = $argv[1]; // Ensure to trim whitespace
$parent_name = $argv[2]; // Trim the parent's name
$time_range = $argv[3]; // Trim the time range

$mail = new PHPMailer(true);

$mail->SMTPDebug = 0;                                       // Enable verbose debug output
$mail->isSMTP();                                            // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                                   // Enable SMTP authentication
$mail->Username = 'deng36553@gmail.com';                 // SMTP username
$mail->Password = 'nbkq zdwh wrfv hcjq';                  // SMTP password
$mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;

// Set up your SMTP details here as in your main code
$mail->setFrom('deng36553@gmail.com', "Children's Clinic");
$mail->addAddress($p_email, 'Recipient');
$mail->isHTML(true);
$mail->Subject = 'Appointment Reminder';
$mail->Body = "Dear $parent_name,<br><br>This is a reminder that you have an appointment scheduled tomorrow at $time_range.<br><br>Please make sure to arrive 10 minutes before your appointment.<br><br>Thank you!";
$mail->AltBody = "Dear $parent_name,\n\nThis is a reminder that you have an appointment scheduled tomorrow at $time_range.\n\nPlease make sure to arrive 10 minutes before your appointment.\n\nThank you!";

try {
  $mail->send();
  echo "Email sent successfully\n";
} catch (Exception $e) {
  echo "Email could not be sent. Error: {$mail->ErrorInfo}\n";
}

?>