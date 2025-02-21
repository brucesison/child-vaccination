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
$sql = "SELECT appointment_date, COUNT(*) as upcoming_count 
        FROM appointment_tbl 
        WHERE status = 'Upcoming' 
        AND appointment_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
        GROUP BY appointment_date";
$result = $conn->query($sql);

$upcomingAppointments = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $upcomingAppointments[$row['appointment_date']] = (int) $row['upcoming_count'];
  }
}

for ($i = 0; $i < 30; $i++) {
  $date = date('Y-m-d', strtotime("+$i days"));
  if (date('N', strtotime($date)) == 7 || in_array($date, array_column($breaks, 'break_date')) || $date < date('Y-m-d')) {
    continue; // Skip Sundays, break days, and past dates
  }
  // Get the count of upcoming appointments for the date
  $appointments_by_day[$date] = isset($upcomingAppointments[$date]) ? $upcomingAppointments[$date] : 0;
}

// Return the response as JSON
echo json_encode(['breaks' => $breaks, 'upcomingAppointments' => $appointments_by_day]);

$conn->close();
?>