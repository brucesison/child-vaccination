<?php
session_start();
include_once "../includes/db_connect.php"; // Ensure this file sets up the $pdo variable for PDO connection

$outgoing_id = $_SESSION['unique_id'];
$searchTerm = $_POST['searchTerm'];

// Prepare the SQL statement with placeholders
$sql = "SELECT * FROM staff_tbl WHERE NOT unique_id = :outgoing_id AND (s_fname LIKE :searchTerm OR  s_lname LIKE :searchTerm )";

// Prepare the PDO statement
$stmt = $pdo->prepare($sql);

// Execute the statement with the necessary parameters
$stmt->execute([
    'outgoing_id' => $outgoing_id,
    'searchTerm' => "%$searchTerm%"
]);

$output = "";

// Check if any rows were returned
if ($stmt->rowCount() > 0) {
    include_once "data.php"; // Assuming this file processes and outputs the result
} else {
    $output .= 'No user found related to your search term';
}

echo $output;
?>