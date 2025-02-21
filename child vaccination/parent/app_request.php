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
  $request_app = $functions->showRequestApp($parent_id);

  $account_status = $parent_info['status'];

  if ($account_status == 'not-verified') {
    $acc_not_verified = 'd-block';
    $request_form = 'd-none';
    $have_app_content = 'd-none';
    $have_pending_content = 'd-none';
  } else {
    $acc_not_verified = 'd-none';
    $request_form = 'd-block';
    $have_app_content = 'd-none';
    $have_pending_content = 'd-none';
    if (!empty($upcoming_app)) {
      $request_form = 'd-none';
      $have_app_content = 'd-block';
    } elseif (!empty($request_app)) {
      $request_form = 'd-none';
      $have_app_content = 'd-none';
      $have_pending_content = 'd-block';
    }
  }

  // get the status of the submitted form (success/error)
  $status = $_GET['status'] ?? '';

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $appointment_menu = '';
  // Check if the current page is 'app_request.php'
  if ($current_page == 'app_request.php') {

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
  <title>Request Appointment</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

  <!-- check if form is submitted successfully -->
  <?php if ($status == 'success'): ?>
    <script>
      Swal.fire({
        title: "",
        text: "Request submitted!",
        icon: "success",
        confirmButtonColor: "#009c95"
      });
    </script>
  <?php elseif ($status == 'cancelled'): ?>
    <script>
      Swal.fire({
        title: "",
        text: "Appointment cancelled!",
        icon: "success",
        confirmButtonColor: "#009c95"
      });
    </script>
  <?php endif; ?>

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

        <!-- Page content if parent account is not verified -->
        <div class="container-fluid <?php echo $acc_not_verified; ?>">
          <div class="row mb-5 mt-3 align-items-center justify-content-center h-100">
            <div class="col-md-12">
              <div class="alert alert-info alert-dismissible fade show small" role="alert">
                <strong><i class="fas fa-fw fa-info-circle mr-1"></i>Note: </strong>Your account is in verification
                process.
              </div>
            </div>
            <div class="col-md-4 d-flex align-items-center justify-content-center">
              <?php include 'img/not_verified.svg'; ?>
            </div>
            <div class="col-md-12 mb-5">
              <p class="text-center">Your account is not verified. You cannot request an appointment.</p>
            </div>
          </div>
        </div>

        <!-- Page content if have no upcoming appointment -->
        <div class="container-fluid <?php echo $request_form ?>">

          <!-- Page Heading -->
          <div class="mb-4">
            <h1 class="h3 mb-0 text-gray-800">Request Appointment</h1>
          </div>

          <?php if (empty($my_child)) { ?>
            <div class="row my-5 align-items-center justify-content-center h-100">
              <div class="col-md-4 d-flex align-items-center justify-content-center">
                <?php include 'img/no_child.svg'; ?>
              </div>
              <div class="col-md-12">
                <h5 class="text-center">Add your child first.</h5>
                <div class="col-md-12 text-center">
                  <a href="add_child.php" class="text-main font-weight-bold">Add now</a>
                </div>
              </div>
            </div>
          <?php } else { ?>
            <!-- appointment request form -->
            <?php include 'includes/app_req_form.php'; ?>
          <?php } ?>

        </div>

        <!-- Page content if have pending request -->
        <div class="container-fluid <?php echo $have_pending_content ?>">
          <div class="col-md-12">
            <div class="alert alert-info alert-dismissible fade show small" role="alert">
              <strong><i class="fas fa-fw fa-info-circle mr-1"></i>Note: </strong>Waiting for approval.
            </div>
          </div>
          <?php
          $appointment_date = $request_app['date_requested'];
          $time_requested = $request_app['time_requested'];
          $cancel_reqdisabled = '';

          // Combine date and time into a single datetime string
          $appointment_datetime = $appointment_date . ' ' . $time_requested;

          // Calculate the target time, which is 3 hours after the appointment datetime
          $target_timestamp = strtotime($appointment_datetime) + (3 * 60 * 60);

          // Get the current timestamp
          $current_timestamp = strtotime(date('Y-m-d H:i:s'));

          // Check if the current time is before the target time
          if ($current_timestamp < $target_timestamp) {
            // Calculate the remaining time in seconds
            $remaining_seconds = $target_timestamp - $current_timestamp;

            // Convert seconds into hours, minutes, and seconds
            $hours = floor($remaining_seconds / 3600);
            $minutes = floor(($remaining_seconds % 3600) / 60);
            $seconds = $remaining_seconds % 60;

            // Display the remaining time
            $cancel_reqbtn = 'btn-outline-danger';
          } else {
            $cancel_reqbtn = 'btn-outline-secondary';
            $cancel_reqdisabled = 'disabled';
            $cancel_reqinfo = 'd-none';
          }
          ?>
          <div class="col-md-12 mb-4">
            <div class="card shadow">
              <div class="card-header">
                <h5 class="m-0 text-dark">You have pending appointment.</h5>
              </div>
              <div class="card-body">
                <div class="row p-3 align-items-center">
                  <div class="col-md-6">

                    <div class="text-secondary mb-3">
                      <span class="font-weight-bold">Appointment Date</span> :
                      <?php
                      // Format the date to include the name of the month
                      $f_date = date("l, F j, Y", strtotime($request_app['appointment_date']));
                      echo $f_date;
                      ?>
                    </div>

                    <div class="text-secondary mb-3">
                      <span class="font-weight-bold">Appointment Time</span> :
                      <?php
                      $app_time = json_decode($request_app['appointment_time'], true);
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
                        $time_range = htmlspecialchars($start_time) . " to " . htmlspecialchars($formatted_end_time);
                        if ($time_range == '10:00 AM to 10:00 AM') {
                          echo '9:30 AM to 10:30 AM';
                        } else {
                          echo $time_range;
                        }
                      }
                      ?>
                    </div>

                    <div class="text-secondary mb-3">
                      <span class="font-weight-bold">Guardian's Name</span> :
                      <?php echo $request_app['guardian_name']; ?>
                    </div>

                    <div class="text-secondary mb-3">
                      <span class="font-weight-bold">Child's Name</span> :
                      <?php
                      $child = json_decode($request_app['child_name'], true);
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
                      $reason = json_decode($request_app['reason_for_visit'], true);
                      if (!empty($reason)) {
                        foreach ($reason as $reasons) {
                          echo htmlspecialchars($reasons) . ", ";
                        }
                      }
                      ?>
                    </div>

                    <button class="btn <?php echo $cancel_reqbtn; ?> btn-sm font-weight-bold mb-2" data-toggle="modal"
                      data-target="#cancel_req" <?php echo $cancel_reqdisabled; ?>>Cancel</button>
                    <p class="text-main small <?php echo $cancel_reqinfo; ?>"><i
                        class="fas fa-fw fa-info-circle mr-1"></i>You can cancel your
                      request
                      within <?php echo "$hours" . "h " . $minutes . "m" ?>.</p>
                    <?php include './modals/cancel_request_modal.php'; ?>
                  </div>

                  <div class="col-md-6 d-flex align-items-center justify-content-center" id="view-app-calendar">
                    <?php include './img/calendar.svg'; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php include './includes/proccess_loading.php'; ?>

        <!-- Page content if have upcoming appointment -->
        <div class="container-fluid <?php echo $have_app_content ?>">
          <div class="col-md-12">
            <div class="alert alert-info alert-dismissible fade show small" role="alert">
              <strong><i class="fas fa-fw fa-info-circle mr-1"></i>Note: </strong>You cannot request an appointment if
              you have upcoming appointment.
            </div>
          </div>
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
          <div class="col-md-12 mb-4">
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
                        $time_range = htmlspecialchars($start_time) . " to " . htmlspecialchars($formatted_end_time);
                        if ($time_range == '10:00 AM to 10:00 AM') {
                          echo '9:30 AM to 10:30 AM';
                        } else {
                          echo $time_range;
                        }
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
                        class="fas fa-fw fa-info-circle mr-1"></i>You can cancel this appointment one day before it.</p>
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

  <script src="app_request.js"></script>
</body>

</html>