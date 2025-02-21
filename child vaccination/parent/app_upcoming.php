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

  $my_child = $functions->showMyChild($parent_id);

  $upcoming_app = $functions->showUpcomingApp($parent_id);

  $no_app_content = 'd-block';
  $have_app_content = 'd-none';
  if (!empty($upcoming_app)) {
    $no_app_content = 'd-none';
    $have_app_content = 'd-block';
  }

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $appointment_menu = '';
  // Check if the current page is 'app_upcoming.php'
  if ($current_page == 'app_upcoming.php') {

    // means appointment menu is active
    $appointment_menu = 'active';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Upcoming Appointment</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php include './includes/sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">


      <div class="content" style="height: 100vh;">

        <!-- Topbar -->
        <?php include './includes/topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Page content if parent have no upcoming appointment -->
        <div class="container-fluid <?php echo $no_app_content; ?>">
          <div class="row mb-5 mt-3 align-items-center justify-content-center h-100">
            <div class="col-md-4 d-flex align-items-center justify-content-center">
              <?php include '../parent/img/no_appointment.svg'; ?>
            </div>
            <div class="col-md-12 mb-5">
              <h6 class="text-center">You have no upcoming appointment.</h6>
            </div>
          </div>
        </div>

        <!-- Page content if have upcoming appointment -->
        <div class="container-fluid <?php echo $have_app_content; ?>">
          <?php
          // check if today is one day before the appointment date
          if (!empty($upcoming_app)) {
            $appointment_date = $upcoming_app['appointment_date'];
            $one_day_before = date('Y-m-d', strtotime($appointment_date . ' -1 day'));
            $current_date = date('Y-m-d');

            $cancel_btn = 'disabled';
            $cancel_btn_style = 'btn-outline-secondary';
            $cancel_info = 'd-block';

            if ($current_date == $one_day_before) {
              $cancel_btn = '';
              $cancel_btn_style = 'btn-outline-danger';
              $cancel_info = 'd-none';
            }
          }
          ?>
          <div class="row mb-5 mt-3 d-flex justify-content-center h-100">
            <!-- Home content if parent have appointment -->
            <div class="col-md-12 mb-4 <?php echo $have_app_content ?>">
              <div class="card shadow">
                <div class="card-header">
                  <h5 class="m-0 text-dark">You have upcoming appointment!</h5>
                </div>
                <div class="card-body">
                  <div class="row p-3 align-items-center">
                    <div class="col-md-6">

                      <div class="text-secondary mb-3">
                        <span class="font-weight-bold">Appointment Date</span> :
                        <?php
                        // Format the date to include the name of the month
                        $f_date = date("l, F j, Y", strtotime($upcoming_app['appointment_date']));
                        echo $f_date;
                        ?>
                      </div>

                      <div class="text-secondary mb-3">
                        <span class="font-weight-bold">Appointment Time</span> :
                        <?php
                        $app_time = json_decode($upcoming_app['appointment_time'], true);
                        if (!empty($app_time) && is_array($app_time)) {
                          // Sort the time slots
                          sort($app_time);

                          // Get the start time (first element)
                          $start_time = $app_time[0];

                          // Calculate the end time (last element + 30 minutes)
                          $end_time = end($app_time);
                          $end_time_datetime = DateTime::createFromFormat('h:i A', $end_time);
                          $end_time_datetime->add(new DateInterval('PT30M'));
                          $formatted_end_time = $end_time_datetime->format('h:i A');

                          // Display the time range
                          echo htmlspecialchars($start_time) . " to " . htmlspecialchars($formatted_end_time);
                        }
                        ?>
                      </div>

                      <div class="text-secondary mb-3">
                        <span class="font-weight-bold">Guardian's Name</span> :
                        <?php echo $upcoming_app['guardian_name']; ?>
                      </div>

                      <div class="text-secondary mb-3">
                        <span class="font-weight-bold">Child's Name</span> :
                        <?php
                        $child = json_decode($upcoming_app['child_name'], true);
                        if (!empty($child)) {
                          foreach ($child as $childs) {
                            echo htmlspecialchars($childs) . ", ";
                          }
                        }
                        ?>
                      </div>

                      <div class="text-secondary mb-3">
                        <span class="font-weight-bold">Reason for visit</span> :
                        <?php
                        $reason = json_decode($upcoming_app['reason_for_visit'], true);
                        if (!empty($reason)) {
                          foreach ($reason as $reasons) {
                            echo htmlspecialchars($reasons) . ", ";
                          }
                        }
                        ?>
                      </div>

                      <button class="btn <?php echo $cancel_btn_style; ?> btn-sm font-weight-bold mb-2" <?php echo $cancel_btn; ?> data-toggle="modal" data-target="#cancel_app">Cancel</button>
                      <!-- Cancel appointment Modal-->
                      <?php include './modals/cancel_appointment_modal.php'; ?>
                      <p class="text-main small <?php echo $cancel_info; ?>"><i
                          class="fas fa-fw fa-info-circle mr-1"></i>You can cancel this appointment one day before it.
                      </p>
                    </div>

                    <div class="col-md-6 d-flex align-items-center justify-content-center" id="view-app-calendar">
                      <?php include './img/calendar.svg'; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

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

</body>

</html>