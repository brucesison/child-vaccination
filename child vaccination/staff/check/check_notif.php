<?php

@include "../includes/db_connect.php";
require "../includes/functions.php";

$app_req = $functions->getAppointmentRequest();
$app_upcoming = $functions->getUpcomingAppointment();

if (empty($app_req) && empty($app_upcoming)) {
  $badge = 'd-none';
}

?>

<span class="badge badge-danger badge-counter <?php echo $badge; ?>">!</span>