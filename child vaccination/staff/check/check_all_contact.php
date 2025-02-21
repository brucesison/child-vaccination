<?php
require "../includes/functions.php";

if (isset($_POST['contact_no'])) {
  $response = 'none';
  $contact_no = $_POST['contact_no'] ?? '';

  $result = $functions->checkAllContact($contact_no);

  $contactExists = false;

  foreach ($result as $row) {
    if ($row['contact_no'] === $contact_no) {
      $contactExists = true;
    }
  }


  if ($contactExists) {
    $response = 'exist';
  } else {
    $response = 'not-exist';
  }

  echo $response;
}
?>