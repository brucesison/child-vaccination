<?php
require 'BigBlueButton.php';

function startMeeting($initiator_id, $selected_participant_id, $initiator_type)
{
  $bbb = new BigBlueButton();

  // Create unique meeting ID and name
  $meetingID = "meeting_{$initiator_id}_{$selected_participant_id}";
  $meetingName = "Video Call between {$initiator_id} and {$selected_participant_id}";

  // Set passwords
  $attendeePassword = 'attendee_pwd';
  $moderatorPassword = 'moderator_pwd';

  // Create meeting using BigBlueButton API
  $query = http_build_query([
    'meetingID' => $meetingID,
    'name' => $meetingName,
    'attendeePW' => $attendeePassword,
    'moderatorPW' => $moderatorPassword,
  ]);

  $checksum = $bbb->generateChecksum("create" . $query);
  $createMeetingUrl = "{$bbb->baseUrl}/create?$query&checksum=$checksum";

  // Make the request to create the meeting
  $response = file_get_contents($createMeetingUrl);
  $xml = simplexml_load_string($response);

  // Check if meeting was created successfully
  if ($xml->returncode == 'SUCCESS') {
    // Save meeting details to the database
    $pdo = new PDO("mysql:host=localhost;dbname=child_appointment", "root", "");
    $stmt = $pdo->prepare("INSERT INTO meeting_tbl (meeting_id, staff_id, user_id, start_time, attendee_password, moderator_password, selected_participant_id, status) VALUES (?, ?, ?, NOW(), ?, ?, ?, 'active')");

    if ($initiator_type == 'staff') {
      $stmt->execute([$meetingID, $initiator_id, $selected_participant_id, $attendeePassword, $moderatorPassword, $selected_participant_id]);
      $joinUrlInitiator = $bbb->getJoinMeetingURL($meetingID, $moderatorPassword, 'Staff');
      $joinUrlParticipant = $bbb->getJoinMeetingURL($meetingID, $attendeePassword, 'User');
    } else {
      $stmt->execute([$meetingID, $selected_participant_id, $initiator_id, $attendeePassword, $moderatorPassword, $selected_participant_id]);
      $joinUrlInitiator = $bbb->getJoinMeetingURL($meetingID, $attendeePassword, 'User');
      $joinUrlParticipant = $bbb->getJoinMeetingURL($meetingID, $moderatorPassword, 'Staff');
    }

    return [
      'initiator_url' => $joinUrlInitiator,
      'participant_url' => $joinUrlParticipant
    ];
  } else {
    return null;
  }
}
?>