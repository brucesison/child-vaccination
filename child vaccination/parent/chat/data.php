<?php
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Prepare the SQL query to fetch the latest message between users
    $sql2 = "SELECT * FROM messages WHERE 
                (incoming_msg_id = :user_id OR outgoing_msg_id = :user_id) 
                AND (outgoing_msg_id = :outgoing_id OR incoming_msg_id = :outgoing_id) 
                ORDER BY msg_id DESC LIMIT 1";

    // Prepare the PDO statement
    $stmt2 = $pdo->prepare($sql2);

    // Execute the statement with the necessary parameters
    $stmt2->execute(['user_id' => $row['unique_id'], 'outgoing_id' => $outgoing_id]);

    // Fetch the result of the query
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    $status = '';
    $msg = "No message available"; // Default message

    // Check if there are any messages
    if ($row2) {
        $result = $row2['msg'];
        $status = $row2['status'];

        // Shorten the message if it's longer than 28 characters
        $msg = (strlen($result) > 28) ? substr($result, 0, 28) . '...' : $result;

        // Determine if the message is from the user or the other person
        $you = ($outgoing_id == $row2['outgoing_msg_id']) ? "You: " : "";

        // Apply bold font weight if the message is not seen and it's not your message
        $font_weight = ($status == "not seen" && empty($you)) ? "font-weight-bold" : "";
    } else {
        $you = ""; // No message available
        $font_weight = ""; // No need for bold if no message
    }

    // Set the status and visibility
    $offline = ($row['session_status'] == "Offline now") ? "offline" : "";
    $hid_me = ($outgoing_id == $row['unique_id']) ? "hide" : "";

    $s_m_name = $row['s_m_initial'];

    // Split the name into words
    $words = explode(' ', $s_m_name);

    // Get the first letter of each word and concatenate with a period
    if (count($words) > 1) {
        // For two words, get the first letter of each
        $initials = strtoupper(substr($words[0], 0, 1)) . strtoupper(substr($words[1], 0, 1)) . '.';
    } else {
        // For one word, get only the first letter
        $initials = strtoupper(substr($s_m_name, 0, 1)) . '.';
    }

    // Build the output HTML
    $output .= '<a href="chat.php?staff_id=' . $row['unique_id'] . '" style="text-decoration:none;">
                    <div class="content">
                    <img class="rounded-circle" src="' . $row['staff_pic'] . '" alt="">
                    <div class="details">
                        <span>' . $row['s_fname'] . ' ' . $initials . ' ' . $row['s_lname'] . '</span>' . '<span class="ml-3 bg-main text-uppercase text-muted p-1 rounded" style="color:white !important; font-size:10px;">' . $row['user_type'] . '</span>
                        <p class="' . $font_weight . '">' . $you . $msg . '</p>
                    </div>
                    </div>
                    <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
                </a>';
}
?>