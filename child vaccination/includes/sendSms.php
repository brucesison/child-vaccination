<?php
require '../staff/vendor_sms/autoload.php';

// api for sms notification
use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;

// Check for required command-line arguments
// if (isset($argv[1]) && isset($argv[2])) {
//   $p_contact = trim($argv[1]);
//   $time_range = trim($argv[2]);
// } else {
//   echo "Required arguments are missing.\n";
//   exit; // Stop execution if the required arguments are not passed
// }

$p_contact = $argv[1];
$time_range = $argv[2];

$message = "This is a reminder that you have an appointment scheduled tomorrow at $time_range. \n\nPlease make sure to arrive 10mins before your appointment.";

$apiURL = "xlzdze.api.infobip.com";
$apiKey = "2a0d9a5c67ee6a5f6d39f09fe3333eba-084b495d-c511-4efd-a41d-a746871f93b5";

$configuration = new Configuration(host: $apiURL, apiKey: $apiKey);
$api = new SmsApi(config: $configuration);

$destination = new SmsDestination(to: $p_contact);
$theMessage = new SmsTextualMessage(destinations: [$destination], text: $message, from: "Doc Bruce");

$request = new SmsAdvancedTextualRequest(messages: [$theMessage]);

try {
  $response = $api->sendSmsMessage($request);
  echo "SMS sent successfully\n";
} catch (Exception $e) {
  echo "SMS could not be sent. Error: {$e->getMessage()}\n";
}

?>