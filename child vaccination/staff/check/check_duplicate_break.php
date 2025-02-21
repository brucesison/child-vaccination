<?php
require "../includes/functions.php";

if (isset($_POST['break_date']) || isset($_POST['reason'])) {
  $response = 'none';
  $break_date = $_POST['break_date'] ?? '';
  $reason = $_POST['reason'] ?? '';

  $result = $functions->checkBreak($break_date, $reason);

  $breakExists = !empty($result);

  if ($breakExists) {
    $response = 'exists';
  } else {
    $response = 'not_exists';
  }

  echo $response;
}
?>