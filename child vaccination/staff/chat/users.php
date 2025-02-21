<?php
session_start();
include_once "../includes/db_connect.php"; // Ensure this file sets up the $pdo variable for PDO connection

$outgoing_id = $_SESSION['unique_id'];

// Prepare the SQL statement to select users except the current user
$sql = "SELECT * FROM user_tbl WHERE NOT unique_id = :outgoing_id ORDER BY user_id DESC";

// Prepare the PDO statement
$stmt = $pdo->prepare($sql);

// Execute the statement with the necessary parameter
$stmt->execute(['outgoing_id' => $outgoing_id]);

$output = "";

// Check if any rows were returned
if ($stmt->rowCount() == 0) {
    $output .= "No users are available to chat";
} elseif ($stmt->rowCount() > 0) {
    include_once "data.php"; // Assuming this file processes and outputs the result
}

echo $output;
?>