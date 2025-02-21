<?php
require "../includes/functions.php";

if (isset($_POST['c_fname']) || isset($_POST['c_m_initial']) || isset($_POST['c_lname']) || isset($_POST['f_fname']) || isset($_POST['f_m_initial']) || isset($_POST['f_lname']) || isset($_POST['m_fname']) || isset($_POST['m_m_initial']) || isset($_POST['m_lname'])) {
  $response = 'none';

  $c_fname = $_POST['c_fname'] ?? '';
  $c_m_initial = $_POST['c_m_initial'] ?? '';
  $c_lname = $_POST['c_lname'] ?? '';
  $f_fname = $_POST['f_fname'] ?? '';
  $f_m_initial = $_POST['f_m_initial'] ?? '';
  $f_lname = $_POST['f_lname'] ?? '';
  $m_fname = $_POST['m_fname'] ?? '';
  $m_m_initial = $_POST['m_m_initial'] ?? '';
  $m_lname = $_POST['m_lname'] ?? '';

  $result = $functions->checkChildDetails($c_fname, $c_m_initial, $c_lname, $f_fname, $f_m_initial, $f_lname, $m_fname, $m_m_initial, $m_lname);

  $childExists = !empty($result);

  if ($childExists) {
    $response = 'exists';
  } else {
    $response = 'not_exists';
  }

  echo $response;
}
?>