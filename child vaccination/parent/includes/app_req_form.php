<div class="card shadow">
  <div class="card-body">
    <form id="request-appointment" action="request/request_appointment.php" method="POST">
      <input type="hidden" name="guardian_name" value="<?php echo $parent_name; ?>">
      <input type="hidden" name="status" value="Upcoming">

      <!-- Content Row -->
      <div class="row my-5 align-items-center justify-content-center h-100">
        <div class="col-md-5 text-center mb-4">
          <h5 class="text-secondary">Date</h5>
          <?php
          // Get the current date minus 1 day (yesterday) in the format YYYY-MM-DD
          $yesterday = date('Y-m-d', strtotime('-1 day'));
          ?>
          <input type="date" class="form-control border border-secondary" name="appointment_date" required
            id="appointment-date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" onchange="checkSunday()">
        </div>
      </div>

      <div class="row align-items-center justify-content-center h-100">

        <div class="col-md-2 mb-3">
          <h5 class="text-secondary text-center">Reason for visit</h5>
          <div class="row align-items-center justify-content-center">
            <div class="dropdown">
              <button type="button" class="btn btn-outline-secondary">Select Options</button>
              <div class="dropdown-content">
                <label><input type="checkbox" name="reason_for_visit[]" value="Vaccination" onchange="updateSelected()">
                  Vaccination</label>
                <label><input type="checkbox" name="reason_for_visit[]" value="Checkup" onchange="updateSelected()">
                  Checkup</label>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-2 mb-3">
          <h5 class="text-secondary text-center">Child</h5>
          <div class="row align-items-center justify-content-center">
            <div class="dropdown">
              <button type="button" class="btn btn-outline-secondary">Select Child</button>
              <div class="dropdown-content">
                <?php foreach ($my_child as $row) {
                  $c_m_name = $row['c_m_name'];

                  // Split the name into words
                  $c_name = explode(' ', $c_m_name);

                  // Get the first letter of each word and concatenate with a period
                  if (count($c_name) > 1) {
                    // For two c_name, get the first letter of each
                    $cmname = strtoupper(substr($c_name[0], 0, 1)) . strtoupper(substr($c_name[1], 0, 1)) . '.';
                  } else {
                    // For one word, get only the first letter
                    $cmname = strtoupper(substr($c_m_name, 0, 1)) . '.';
                  }
                  ?>
                  <label><input type="checkbox" class="child-checkbox" name="child_name[]"
                      value="<?php echo $row['c_fname'] . ' ' . $cmname . ' ' . $row['c_lname']; ?>"
                      onclick="updateTimeCheckboxes()" onchange="updateSelected()">
                    <?php echo $row['c_fname'] . ' ' . $cmname . ' ' . $row['c_lname']; ?></label>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-5 align-items-center justify-content-center">
        <div class="col-md-2"></div>
        <div class="col-md-2"></div>
        <div class="col-md-2">
          <!-- Selected reasons for visit will display here -->
          <div id="selected-reason-for-visit">
            <p class="ml-4 text-left small">No reason selected</p>
          </div>
        </div>
        <div class="col-md-2">
          <!-- Selected children will display here -->
          <div id="selected-child">
            <p class="ml-4 text-left small">No child selected</p>
          </div>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-2"></div>
      </div>

      <!-- content row -->
      <div class="row align-items-center justify-content-center h-100">
        <h4 class="col-md-12 text-center">Time</h4>
        <div class="col-md-12">
          <div class="row align-items-center justify-content-center">
            <div class="time">
              <div class="time-column">
                <h5>Morning</h5>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="8:00 AM"
                    onclick="updateTimeCheckboxes()"> 8:00 AM</label><br>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="8:30 AM"
                    onclick="updateTimeCheckboxes()"> 8:30 AM</label><br>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="9:00 AM"
                    onclick="updateTimeCheckboxes()"> 9:00 AM</label><br>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="9:30 AM"
                    onclick="updateTimeCheckboxes()"> 9:30 AM</label><br>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="10:00 AM"
                    onclick="updateTimeCheckboxes()"> 10:00 AM</label><br>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="10:30 AM"
                    onclick="updateTimeCheckboxes()"> 10:30 AM</label><br>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="11:00 AM"
                    onclick="updateTimeCheckboxes()"> 11:00 AM</label><br>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="11:30 AM"
                    onclick="updateTimeCheckboxes()"> 11:30 AM</label><br>
              </div>

              <div class="time-column">
                <h5>Afternoon</h5>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="1:30 PM"
                    onclick="updateTimeCheckboxes()"> 1:30 PM</label><br>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="2:00 PM"
                    onclick="updateTimeCheckboxes()"> 2:00 PM</label><br>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="2:30 PM"
                    onclick="updateTimeCheckboxes()"> 2:30 PM</label><br>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="3:00 PM"
                    onclick="updateTimeCheckboxes()"> 3:00 PM</label><br>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="3:30 PM"
                    onclick="updateTimeCheckboxes()"> 3:30 PM</label><br>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="4:00 PM"
                    onclick="updateTimeCheckboxes()"> 4:00 PM</label><br>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="4:30 PM"
                    onclick="updateTimeCheckboxes()"> 4:30 PM</label><br>
                <label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="5:00 PM"
                    onclick="updateTimeCheckboxes()"> 5:00 PM</label><br>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- content row -->
      <div class="row my-5 align-items-center justify-content-center h-100">
        <button type="submit" id="request-btn" class="btn btn-main">Submit</button>
      </div>
    </form>
  </div>
</div>

<script>
  function updateSelected() {
    // Get selected reasons for visit
    const selectedReasons = document.querySelectorAll('input[name="reason_for_visit[]"]:checked');
    const reasonDisplay = document.getElementById('selected-reason-for-visit');
    reasonDisplay.innerHTML = ''; // Clear previous selections
    if (selectedReasons.length > 0) {
      selectedReasons.forEach((checkbox) => {
        const reason = document.createElement('p');
        reason.classList.add('ml-4', 'text-left', 'small');
        reason.textContent = checkbox.value;
        reasonDisplay.appendChild(reason);
      });
    } else {
      reasonDisplay.innerHTML = '<p class="ml-4 text-left small">No reason selected</p>';
    }

    // Get selected children
    const selectedChildren = document.querySelectorAll('input[name="child_name[]"]:checked');
    const childDisplay = document.getElementById('selected-child');
    childDisplay.innerHTML = ''; // Clear previous selections
    if (selectedChildren.length > 0) {
      selectedChildren.forEach((checkbox) => {
        const child = document.createElement('p');
        child.classList.add('ml-4', 'text-left', 'small');
        child.textContent = checkbox.value;
        childDisplay.appendChild(child);
      });
    } else {
      childDisplay.innerHTML = '<p class="ml-4 text-left small">No child selected</p>';
    }
  }
</script>

<!-- loading after submit button clicked -->
<script>
  $(document).ready(function () {
    // When reschedule button is clicked
    $('#request-btn').click(function () {

      // Prevent the form submission initially
      event.preventDefault();

      // Validate form inputs
      var isValid = true;

      // Check required input fields
      $('#request-appointment input[required]').each(function () {
        if ($(this).val() === '') {
          isValid = false;
          Swal.fire({
            title: "",
            text: "Please select date",
            icon: "warning",
            confirmButtonColor: "#009c95"
          });
          return false; // Stop checking further if one field is invalid
        }
      });

      // Check if at least one checkbox is selected (for child_name[])
      if ($('input[name="child_name[]"]:checked').length === 0) {
        isValid = false;
        Swal.fire({
          title: "",
          text: "Please select at least one child",
          icon: "warning",
          confirmButtonColor: "#009c95"
        });
        return false; // Stop checking further if one field is invalid
      }

      // Check if at least one checkbox is selected (for reason_for_visit[])
      if ($('input[name="reason_for_visit[]"]:checked').length === 0) {
        isValid = false;
        Swal.fire({
          title: "",
          text: "Please select at least one reason",
          icon: "warning",
          confirmButtonColor: "#009c95"
        });
        return false; // Stop checking further if one field is invalid
      }

      const childCheckboxes = document.querySelectorAll('.child-checkbox:checked');
      const timeCheckboxes = document.querySelectorAll('.time-checkbox');
      const selectedCount = Array.from(timeCheckboxes).filter(cb => cb.checked).length;
      const requiredCount = childCheckboxes.length;
      if ($('input[name="appointment_time[]"]:checked').length != requiredCount) {
        isValid = false;
        Swal.fire({
          title: "",
          text: `Please select ${requiredCount} appointment time slot`,
          icon: "warning",
          confirmButtonColor: "#009c95"
        });
        return false; // Stop checking further if one field is invalid
      }

      if (isValid) {
        // Show the loading animation
        $('#loading-proccess').css('display', 'flex').fadeIn('fast');

        // Delay the form submission by 1 second
        setTimeout(function () {
          $('#request-appointment').submit(); // Submit the form after the delay
        }, 500); // 1000 milliseconds = 1 second
      }
    });
  });
</script>