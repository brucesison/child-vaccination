<?php

@include "includes/db_connect.php";
require "includes/functions.php";

session_start();

// Check if user is logged in
if (!isset($_SESSION['parent_loggedin'])) {
  header("Location: access_denied.php");
  exit;
} else {
  $parent_id = $_SESSION["parent_id"];
  $parent_name = $_SESSION["parent_name"];
  $parent_info = $functions->parentInfo($parent_id);
  $unique_id = $parent_info['unique_id'];
  $upcoming_app = $functions->showUpcomingApp($parent_id);

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $calendar_active = '';
  // Check if the current page is 'app_break.php'
  if ($current_page == 'calendar.php') {

    // means appointment menu is active
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

            <div class="col-md-12 mb-3">
              <div class="alert alert-info alert-dismissible fade show small" role="alert">
                <?php if (!empty($upcoming_app)) { ?>
                  <strong><i class="fas fa-fw fa-info-circle mr-1"></i></strong>Your appointment is on
                  <?php
                  $f_date = date("l, F j, Y", strtotime($upcoming_app['appointment_date']));
                  echo $f_date;
                  ?>
                <?php } else { ?>
                  <strong><i class="fas fa-fw fa-info-circle mr-1"></i></strong>You don't have an appointment.
                <?php } ?>
              </div>
            </div>

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
              var today = moment().format('YYYY-MM-DD');

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

              // Display available slots
              var availableSlots = data.availableSlots[date.format('YYYY-MM-DD')];
              if (date.format('YYYY-MM-DD') !== today && availableSlots !== undefined) {
                cell.append(
                  '<div class="available-slots text-primary text-center small font-weight-bold mt-4">' + availableSlots + '<br><p class="">Slot</p></div>'
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

</body>

</html>