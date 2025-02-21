<?php
require "../includes/functions.php";

if (isset($_POST['vaccine_name'])) {
  $response = 'none';
  $vaccine_name = $_POST['vaccine_name'] ?? '';

  $result = $functions->checkVaccine($vaccine_name);

  $vaccineExists = !empty($result);

  if ($vaccineExists) {
    $response = 'exists';
  } else {
    $response = 'not_exists';
  }

  echo $response;
}
?>