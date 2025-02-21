<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "../includes/db_connect.php"; // Ensure this file sets up the $pdo variable for PDO connection
    $outgoing_id = $_SESSION['unique_id'];

    // Validate and sanitize the 'incoming_id' and 'message' parameters from the POST request
    $incoming_id = filter_input(INPUT_POST, 'incoming_id', FILTER_SANITIZE_NUMBER_INT);
    $message = trim($_POST['message']);
    $time_stamp = date('Y-m-d H:i:s');
    $status = "not seen";

    if (!empty($message)) {
        // Prepare the SQL statement
        $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, time_stamp, status)
                VALUES (:incoming_id, :outgoing_id, :message, :time_stamp, :status)";

        // Prepare the PDO statement
        $stmt = $pdo->prepare($sql);

        // Execute the statement with the necessary parameters
        $stmt->execute([
            'incoming_id' => $incoming_id,
            'outgoing_id' => $outgoing_id,
            'message' => $message,
            'time_stamp' => $time_stamp,
            'status' => $status
        ]);
    }
} else {
    header("location: ../index.php");
    exit;
}
?>