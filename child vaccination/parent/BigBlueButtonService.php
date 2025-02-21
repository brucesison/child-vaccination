<?php

require 'vendor/autoload.php';

use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;
use BigBlueButton\Enum\Role;  // Import Role for user roles

class BigBlueButtonService
{
  private $bbb;

  public function __construct()
  {
    $this->bbb = new BigBlueButton();
  }

  public function createMeeting($meetingID, $meetingName)
  {
    $createParams = new CreateMeetingParameters($meetingID, $meetingName);
    $createParams->setWelcomeMessage("Welcome to the video call!");

    // Create the meeting and check for success
    $response = $this->bbb->createMeeting($createParams);
    return $response->getReturnCode() === 'SUCCESS' ? $response : null;
  }

  public function getJoinMeetingURL($meetingID, $role, $userName)
  {
    // Create join parameters
    $joinParams = new JoinMeetingParameters($meetingID, $userName, $role);

    // Generate and return the join URL
    return $this->bbb->getJoinMeetingURL($joinParams);
  }
}
