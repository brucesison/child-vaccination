<?php
require "../includes/functions.php";

if (isset($_POST['email'])) {
  $response = 'none';
  $email = $_POST['email'] ?? '';

  $result = $functions->checkallEmail($email);

  $emailExists = false;

  foreach ($result as $row) {
    if ($row['email'] === $email) {
      $emailExists = true;
    }
  }


  if ($emailExists) {
    $response = 'exist';
  } else {
    $response = 'not-exist';
  }

  echo $response;
}
?>