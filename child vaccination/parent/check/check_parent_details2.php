<?php
require "../includes/functions.php";

if (isset($_POST['email']) || isset($_POST['contact_no'])) {
    $response = 'none';
    $email = $_POST['email'] ?? '';
    $contact_no = $_POST['contact_no'] ?? '';

    $emailExists = false;
    $contactExists = false;

    if ($email !== '') {
        $result = $functions->checkParentDetails($email, '');
        foreach ($result as $row) {
            if ($row['email'] === $email) {
                $emailExists = true;
                break;
            }
        }
    }

    if ($contact_no !== '') {
        $result = $functions->checkParentDetails('', $contact_no);
        foreach ($result as $row) {
            if ($row['contact_no'] === $contact_no) {
                $contactExists = true;
                break;
            }
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
