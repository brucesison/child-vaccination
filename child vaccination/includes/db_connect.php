<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'child_appointment';
$username = 'root';
$password = '';

try {
    // Establish database connection using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors gracefully
    // die("Database connection failed: " . $e->getMessage());
    header('location: 504.php');
}
?>