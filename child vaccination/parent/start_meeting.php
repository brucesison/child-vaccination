<?php
require 'BigBlueButtonService.php';

$bbbService = new BigBlueButtonService();
$meetingID = uniqid('meeting_');

// Check if a user or staff member is selected
if (isset($_POST['staff_id'])) {
  $participantID = $_POST['staff_id'];
  $participantType = 'staff';
} elseif (isset($_POST['user_id'])) {
  $participantID = $_POST['user_id'];
}

// Database connection
$pdo = new PDO("mysql:host=localhost;dbname=your_db", "username", "password");

// Get participant's name
$table = $participantType === 'staff' ? 'staff_tbl' : 'user_tbl';
$stmt = $pdo->prepare("SELECT name FROM $table WHERE id = ?");
$stmt->execute([$participantID]);
$participantName = $stmt->fetchColumn();

// Define meeting name
$meetingName = "Video Call with $participantName";

// Create the meeting
$response = $bbbService->createMeeting($meetingID, $meetingName);
if ($response) {
  // Generate URLs with Role constants
  $moderatorURL = $bbbService->getJoinMeetingURL($meetingID, Role::MODERATOR, 'Initiator');
  $attendeeURL = $bbbService->getJoinMeetingURL($meetingID, Role::VIEWER, $participantName);

  echo "<h2>Video Call Started</h2>";
  echo "<p>Moderator URL: <a href='$moderatorURL' target='_blank'>Join as Moderator</a></p>";
  echo "<p>Attendee URL: <a href='$attendeeURL' target='_blank'>Join as Attendee</a></p>";
} else {
  echo "Failed to create the meeting.";
}
?>