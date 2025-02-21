<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "../includes/db_connect.php"; // Ensure this file sets up the $pdo variable for PDO connection
    $outgoing_id = $_SESSION['unique_id'];

    // Validate and sanitize the 'incoming_id' parameter from the POST request
    $incoming_id = filter_input(INPUT_POST, 'incoming_id', FILTER_SANITIZE_NUMBER_INT);

    $output = "";

    // Prepare the SQL statement
    $sql = "SELECT * FROM messages 
            LEFT JOIN staff_tbl ON staff_tbl.unique_id = messages.outgoing_msg_id
            WHERE (outgoing_msg_id = :outgoing_id AND incoming_msg_id = :incoming_id)
            OR (outgoing_msg_id = :incoming_id AND incoming_msg_id = :outgoing_id) 
            ORDER BY msg_id";

    // Prepare the PDO statement
    $stmt = $pdo->prepare($sql);

    // Execute the statement with the necessary parameters
    $stmt->execute([
        'outgoing_id' => $outgoing_id,
        'incoming_id' => $incoming_id
    ]);

    // Fetch all results
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach ($rows as $row) {
            if ($row['outgoing_msg_id'] === $outgoing_id) {
                $output .= '<div class="chat outgoing">
                            <div class="details">
                                <p>' . htmlspecialchars($row['msg']) . '</p>
                            </div>
                            </div>';
            } else {
                if (strpos($row['msg'], "https://meet.jit.si/") !== false) {
                    // Extract the number from the link
                    if (preg_match('/https:\/\/meet\.jit\.si\/(\d+)/', $row['msg'], $matches)) {
                        $room_name = $matches[1]; // The number from the link
                        $_SESSION['room_name'] = $room_name;
                    }
                    $output .= '<div class="chat incoming">
                            <img src="' . $row['staff_pic'] . '" class="rounded-circle" alt="">
                            <a href="meet.php?outgoing_id=' . $outgoing_id . '&incoming_id=' . $incoming_id . '" class="details">
                                <p>Click Here to Join meet</p>
                            </a>
                            </div>';
                } else {
                    $output .= '<div class="chat incoming">
                            <img src="' . $row['staff_pic'] . '" class="rounded-circle" alt="">
                            <div class="details">
                                <p>' . htmlspecialchars($row['msg']) . '</p>
                            </div>
                            </div>';
                }
            }
        }
    } else {
        $output .= '<div class="text">No messages are available. Once you send a message, they will appear here.</div>';
    }

    echo $output;
} else {
    header("location: ../index.php");
    exit;
}
?>