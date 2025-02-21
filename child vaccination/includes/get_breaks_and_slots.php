<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'child_appointment';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch break days
$sql = "SELECT break_date, reason FROM break_tbl";
$result = $conn->query($sql);

$breaks = array();
while ($row = $result->fetch_assoc()) {
  $breaks[] = $row;
}

// Fetch appointments
$sql = "SELECT appointment_date, appointment_time FROM appointment_tbl WHERE status IN ('Pending', 'Upcoming')";
$result = $conn->query($sql);

$appointments = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $date = $row['appointment_date'];
    $times = json_decode($row['appointment_time'], true); // Decode JSON

    if (!isset($appointments[$date])) {
      $appointments[$date] = [];
    }
    $appointments[$date] = array_merge($appointments[$date], $times); // Add times to the respective date
  }
}

// Calculate available slots for the next 30 days
$available_slots = [];
$available_slots_per_day = 16; // Total available slots per day

for ($i = 0; $i < 30; $i++) {
  $date = date('Y-m-d', strtotime("+$i days"));
  if (date('N', strtotime($date)) == 7 || in_array($date, array_column($breaks, 'break_date')) || $date < date('Y-m-d')) {
    continue; // Skip Sundays, break days, and past dates
  }

  // Determine the number of booked slots for this date
  $booked_slots = isset($appointments[$date]) ? count($appointments[$date]) : 0;
  $remaining_slots = max($available_slots_per_day - $booked_slots, 0);

  $available_slots[$date] = $remaining_slots; // Store the available slots for the date
}

// Return the response as JSON
echo json_encode(['breaks' => $breaks, 'availableSlots' => $available_slots]);

$conn->close();
?>