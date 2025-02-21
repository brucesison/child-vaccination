<?php if ($parent_info['status'] == 'verified') { ?>
  <!-- Home content if parent have no appointment -->
  <div class="col-md-12 mb-4 <?php echo $no_app_content ?>">
    <div class="card shadow">
      <div class="card-body">
        <div class="col-md-4 d-flex align-items-center justify-content-center mx-auto">
          <?php include './img/request_appointment.svg'; ?>
        </div>
        <div class="col-md-12 my-3 text-center text-main">You have no upcoming appointment.</div>
        <div class="col-md-12 small my-3 text-center">Request appointment for vaccination or check-up of your child!</div>
        <div class="col-md-12 d-flex justify-content-center">
          <a href="app_request.php" class="btn btn-main btn-sm w-25">Go</a>
        </div>
      </div>
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
  <!-- Home content if parent have appointment -->
  <div class="col-md-12 mb-4 <?php echo $have_app_content ?>">
    <div class="card shadow">
      <div class="card-header">
        <h5 class="m-0 text-dark">
          <?php
          $appointmentDate = $upcoming_app['appointment_date'];

          // Get today's date in 'Y-m-d' format
          $today = date('Y-m-d');

          if ($appointmentDate === $today) {
            echo "You have appointment today!";
          } else {
            echo "You have upcoming appointment!";
          }
          ?>
        </h5>
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
              <span class="font-weight-bold">Guardian's Name</span> : <?php echo $upcoming_app['guardian_name']; ?>
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

            <button class="btn <?php echo $cancel_btn_style; ?> btn-sm font-weight-bold mb-2" <?php echo $cancel_btn; ?>
              data-toggle="modal" data-target="#cancel_app">Cancel</button>
            <!-- Cancel appointment Modal-->
            <?php include './modals/cancel_appointment_modal.php'; ?>
            <p class="text-main small <?php echo $cancel_info; ?>"><i class="fas fa-fw fa-info-circle mr-1"></i>You can
              cancel this appointment one day before it.</p>
          </div>

          <div class="col-md-6 d-flex align-items-center justify-content-center" id="view-app-calendar">
            <?php include './img/calendar.svg'; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } else { ?>
  <div class="col-md-12 mb-4">
    <div class="card shadow">
      <div class="card-body">
        <div class="col-md-12">
          <div class="alert alert-info alert-dismissible fade show small" role="alert">
            <strong><i class="fas fa-fw fa-info-circle mr-1"></i>Note: </strong>Your account is in verification
            process.
          </div>
        </div>
        <div class="col-md-4 d-flex align-items-center justify-content-center mx-auto">
          <?php include 'img/not_verified.svg'; ?>
        </div>
        <div class="col-md-12 mb-5">
          <p class="text-center">Your account is not verified. You cannot request an appointment.</p>
        </div>
      </div>
    </div>
  </div>
<?php } ?>