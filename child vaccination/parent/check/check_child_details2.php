<?php
require "../includes/functions.php";

if (isset($_POST['c_fname']) || isset($_POST['f_fname']) || isset($_POST['m_fname'])) {
  $response = 'none';

  $c_fname = $_POST['c_fname'] ?? '';
  $f_fname = $_POST['f_fname'] ?? '';
  $m_fname = $_POST['m_fname'] ?? '';

  $result = $functions->checkChildDetails2($c_fname, $f_fname, $m_fname);

  $childExists = !empty($result);

  if ($childExists) {
    $response = 'exists';
  } else {
    $response = 'not_exists';
  }

  echo $response;
}
?>