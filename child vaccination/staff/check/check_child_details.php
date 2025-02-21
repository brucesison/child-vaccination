<?php
require "../includes/functions.php";

if (isset($_POST['c_fname']) || isset($_POST['c_m_name']) || isset($_POST['c_lname']) || isset($_POST['f_fname']) || isset($_POST['f_m_name']) || isset($_POST['f_lname']) || isset($_POST['m_fname']) || isset($_POST['m_m_name']) || isset($_POST['m_lname'])) {
  $response = 'none';

  $c_fname = $_POST['c_fname'] ?? '';
  $c_m_name = $_POST['c_m_name'] ?? '';
  $c_lname = $_POST['c_lname'] ?? '';
  $f_fname = $_POST['f_fname'] ?? '';
  $f_m_name = $_POST['f_m_name'] ?? '';
  $f_lname = $_POST['f_lname'] ?? '';
  $m_fname = $_POST['m_fname'] ?? '';
  $m_m_name = $_POST['m_m_name'] ?? '';
  $m_lname = $_POST['m_lname'] ?? '';

  $result = $functions->checkChildDetails($c_fname, $c_m_name, $c_lname, $f_fname, $f_m_name, $f_lname, $m_fname, $m_m_name, $m_lname);

  $childExists = !empty($result);

  if ($childExists) {
    $response = 'exists';
  } else {
    $response = 'not_exists';
  }

  echo $response;
}
?>