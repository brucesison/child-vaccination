<?php
require "../includes/functions.php";

if (isset($_POST['email']) || isset($_POST['contact_no'])) {
    $response = 'none';
    $email = $_POST['email'] ?? '';
    $contact_no = $_POST['contact_no'] ?? '';

    $result = $functions->checkSecretaryDetails($email, $contact_no);

    $emailExists = false;
    $contactExists = false;

    foreach ($result as $row) {
        if ($row['email'] === $email) {
            $emailExists = true;
        }
        if ($row['contact_no'] === $contact_no) {
            $contactExists = true;
        }
    }


    if ($emailExists && $contactExists) {
        $response = 'both';
    } elseif ($emailExists) {
        $response = 'email';
    } elseif ($contactExists) {
        $response = 'contact';
    }

    echo $response;
}
?>