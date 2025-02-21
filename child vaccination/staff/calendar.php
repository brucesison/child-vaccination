<?php

@include "includes/db_connect.php";
require "includes/functions.php";

session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_loggedin']) && !isset($_SESSION['secretary_loggedin'])) {
  header("Location: access_denied.php");
  exit;
} else {
  $staff_id = $_SESSION["staff_id"];
  $staff_name = $_SESSION["staff_name"];

  $staff_info = $functions->staffInfo($staff_id);
  $unique_id = $staff_info['unique_id'];

  $user_type = $staff_info['user_type'];
  $admin_access = 'd-none';
  if ($user_type == 'doctor') {
    $admin_access = '';
  }

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $calendar_active = '';
  if ($current_page == 'calendar.php') {
    $calendar_active = 'active';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Calendar</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include './libraries/libraries.php'; ?>
  <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
  <style>
    .break-day {
      background-color: #d4d4d4 !important;
      color: #e74a3b !important;
    }

    .break-day-reason {
      font-size: 0.8em;
      padding: 2px;
      /* display: none; */
    }

    .fc-day-number {
      color: #009c95;
      font-weight: bold;
    }
  </style>
</head>

<body id="page-top">

  <!-- page loader -->
  <?php include './includes/page_loader.php'; ?>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php include './includes/sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include './includes/topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->
          <div class="row my-5 d-flex align-items-center h-100">

            <div class="col-md-12">
              <div id='calendar'></div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php include './includes/footer.php'; ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Custom scripts for sidebar and scrolling-->
  <script src="js/sb-admin-2.min.js"></script>

  <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
  <script>
    $(document).ready(function () {
      console.log("Initializing calendar...");

      $.ajax({
        url: 'check/get_breaks_and_slots.php', // Updated to a new PHP file
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          console.log("Fetched data: ", data); // Log the fetched data

          // Initialize FullCalendar after fetching breaks and slots
          $('#calendar').fullCalendar({
            dayRender: function (date, cell) {
              console.log("Rendering date: ", date.format('YYYY-MM-DD'));

              // Check if the date is a Sunday
              if (date.day() === 0) { // 0 is Sunday in moment.js
                cell.css("background-color", "#d4d4d4");
                cell.css("color", "white");
              }

              // Check for breaks
              data.breaks.forEach(function (breakData) {
                var breakDate = breakData.break_date;
                var reason = breakData.reason;

                if (date.format('YYYY-MM-DD') === breakDate) {
                  console.log("Break found for date: ", breakDate, " Reason: ", reason);
                  cell.addClass('break-day');
                  cell.append('<div class="break-day-reason small text-center mt-4 font-weight-bold">' + reason + '</div>');
                }
              });

              // Display upcoming appointment count
              var upcomingAppointments = data.upcomingAppointments[date.format('YYYY-MM-DD')];
              if (upcomingAppointments !== undefined) {
                cell.append(
                  '<div class="available-slots text-center small font-weight-bold mt-4"><a href="app_upcoming.php" class="text-success">' + upcomingAppointments + '<br><span class="text-secondary">Upcoming <br> appointments</span></a></div>'
                );
              }
            }
          });

          console.log("Calendar initialized.");
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("AJAX call failed: ", textStatus, errorThrown);
        }
      });

    });
  </script>

  <!-- Script to display realtime notif badge in appointment tab -->
  <script src="check/check_badge.js"></script>


</body>

</html>