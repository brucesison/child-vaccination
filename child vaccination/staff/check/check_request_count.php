<?php

@include "../includes/db_connect.php";
require "../includes/functions.php";

$request2 = $functions->getRequestCount2();
$app_req = $functions->getAppointmentRequest();

if (empty($app_req)) {
  $badge2 = 'd-none';
}

?>

<span class="badge badge-danger badge-counter <?php echo $badge2; ?>">
  <?php foreach ($request2 as $count1) {
    foreach ($count1 as $key => $val)
      echo $val;
  } ?>
</span>