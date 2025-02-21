<div class="modal fade" id="edit_secretary" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-dark text-uppercase" id="exampleModalLabel">Edit Secretary</h5>
      </div>
      <form id="update_details_form" action="edit/edit_s_details.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="default_contact_no" value="<?php echo $secretary['contact_no']; ?>">
        <input type="hidden" id="default_email" value="<?php echo $secretary['email']; ?>">
        <input type="hidden" name="staff_id" value="<?php echo $secretary['staff_id']; ?>">
        <div class="modal-body bg-light">
          <!-- <div class="mt-3 mb-4 text-dark text-center">Account Details</div> -->
          <div id="alertcontact-area" class=""></div>
          <div id="alertcontact2-area" class=""></div>
          <div id="alertemail-area" class=""></div>
          <div class="row mb-4">
            <div class="col-md-4">
              <p class="text-center">First Name<span class="small"><span class="text-danger">*</span></p>
              <input class="form-control border border-secondary" name="s_fname" type="text"
                value="<?php echo $secretary['s_fname']; ?>" required minlength="3" maxlength="15" pattern="[A-Za-z\s]+"
                title="Only alphabetic characters are allowed">
            </div>
            <div class="col-md-4">
              <p class="text-center">Middle Name<span class="small"><span class="text-danger">*</span></p>
              <input class="form-control border border-secondary" name="s_m_initial" type="text"
                value="<?php echo $secretary['s_m_initial']; ?>" required minlength="3" maxlength="20"
                pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
            </div>
            <div class="col-md-4">
              <p class="text-center">Last Name<span class="small"><span class="text-danger">*</span></p>
              <input class="form-control border border-secondary" name="s_lname" type="text"
                value="<?php echo $secretary['s_lname']; ?>" required minlength="3" maxlength="15" pattern="[A-Za-z\s]+"
                title="Only alphabetic characters are allowed">
            </div>
          </div>
          <div class="input-group mb-4">
            <p class="col-12 text-center">Contact No. <span class="text-danger">*</span></p>
            <div class="input-group-append">
              <span class="input-group-text">
                +63
              </span>
            </div>
            <input class="form-control border border-secondary" id="contact_no" name="contact_no" type="text"
              placeholder="9912367..." value="<?php echo $secretary['contact_no']; ?>" placeholder="991236...."
              oninput="contactInput(event)" required maxlength="10" pattern="\d{10}">
          </div>
          <div class="mb-3">
            <p class="text-center">Email address <span class="text-danger">*</span></p>
            <input class="form-control border border-secondary" id="email" name="email" type="email"
              value="<?php echo $secretary['email']; ?>" placeholder="Input gmail" required minlength="13"
              maxlength="50">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-main" id="update-btn">
            <i class="fas fa-fw fa-check mr-1"></i>Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- script to handle invalid gmail -->
<script>
  document.getElementById('email').addEventListener('input', function (event) {
    const emailField = event.target;
    const gmailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
    if (!gmailPattern.test(emailField.value)) {
      emailField.setCustomValidity("Please enter a valid Gmail address ending with '@gmail.com'.");
    } else {
      emailField.setCustomValidity("");
    }
  });
</script>

<!-- script to handle invalid inputs -->
<script>
  let isContactValid = false;
  let isEmailValid = false;

  // Function to update button state
  function updateAddButtonState() {
    const addButton = document.getElementById('update-btn');
    // Enable the button only if both contact number and email are valid
    if (isEmailValid && isContactValid) {
      addButton.disabled = false;
    } else {
      addButton.disabled = true;
    }
  }

  // Function to validate contact number format (must start with 9 and be 10 digits long)
  function isValidContactNumber(contactNumber) {
    return /^9\d{9}$/.test(contactNumber); // Only allow if the number starts with 9 and has 10 digits
  }

  $(document).ready(function () {
    var defaultContactNo = $('#default_contact_no').val();
    isContactValid = true; // Default to true if no contact change is made

    $('#contact_no').on('input', function () {
      var currentContactNo = $('#contact_no').val();
      var alertArea = $('#alertcontact-area');
      var alertArea2 = $('#alertcontact2-area');

      // Clear previous alerts
      alertArea.empty();
      alertArea2.empty();

      // Validate the contact number format first
      if (!isValidContactNumber(currentContactNo)) {
        alertArea.html('<div class="alert alert-danger">Contact number must start with 9 and be exactly 10 digits long.</div>');
        isContactValid = false;
        updateAddButtonState();
        return;
      }

      // Only perform AJAX if the contact number has changed and passed format validation
      if ((currentContactNo !== defaultContactNo)) {
        $.ajax({
          type: 'POST',
          url: './check/check_all_contact.php',
          data: {
            contact_no: currentContactNo !== defaultContactNo ? currentContactNo : ''
          },
          success: function (response) {
            response = response.trim();

            // Check if the contact number already exists
            if (response === 'exist') {
              alertArea2.html('<div class="col-md-12 alert alert-danger">Contact number is already in use!</div>');
              isContactValid = false;
            } else {
              isContactValid = true;
            }

            // Update the button state based on all validations
            updateAddButtonState();
          }
        });
      } else {
        isContactValid = true; // Reset to valid if no change in contact number
        updateAddButtonState();
      }
    });
  });

  $(document).ready(function () {
    var defaultEmail = $('#default_email').val();
    isEmailValid = true; // Default to true if no email change is made

    $('#email').on('input', function () {
      var currentEmail = $('#email').val();
      var alertArea3 = $('#alertemail-area');

      // Clear previous alerts
      alertArea3.empty();

      // Only perform AJAX if the email has changed
      if ((currentEmail !== defaultEmail)) {
        $.ajax({
          type: 'POST',
          url: './check/check_all_email.php',
          data: {
            email: currentEmail !== defaultEmail ? currentEmail : ''
          },
          success: function (response) {
            response = response.trim();

            // Check if the email already exists
            if (response === 'exist') {
              alertArea3.html('<div class="col-md-12 alert alert-danger">Email is already in use!</div>');
              isEmailValid = false;
            } else {
              isEmailValid = true;
            }

            // Update the button state based on all validations
            updateAddButtonState();
          }
        });
      } else {
        isEmailValid = true; // Reset to valid if no change in email
        updateAddButtonState();
      }
    });
  });
</script>

<!-- script to handle update-btn proccess  -->
<script>
  $(document).ready(function () {
    $('#update-btn').click(function (event) {
      // Prevent the default form submission
      event.preventDefault();

      // Validate form inputs using browser's built-in validation
      var form = document.getElementById('update_details_form');

      // Check if form is valid
      if (form.checkValidity() === false) {
        // If form is not valid, let the browser show validation errors
        form.reportValidity();
        return;
      }

      // Delay the form submission by 0.5 second
      setTimeout(function () {
        form.submit(); // Submit the form after the delay
      }, 500);
    });
  });
</script>