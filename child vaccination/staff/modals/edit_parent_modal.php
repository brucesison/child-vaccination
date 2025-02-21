<div class="modal fade" id="edit_parent" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-dark text-uppercase" id="exampleModalLabel">Edit Parent</h5>
      </div>
      <form id="update_details_form" action="edit/edit_p_details.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="default_contact_no" value="<?php echo $parent['contact_no']; ?>">
        <input type="hidden" id="default_email" value="<?php echo $parent['email']; ?>">
        <input type="hidden" name="user_id" value="<?php echo $parent['user_id']; ?>">
        <div class="modal-body bg-light">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12 mt-3 mb-4 text-dark text-center">Account Details</div>
              <div class="col-md-6">
                <div class="row">
                  <div id="alertcontact-area" class="col-md-12"></div>
                  <div id="alertcontact2-area" class="col-md-12"></div>
                  <div id="alertemail-area" class="col-md-12"></div>

                  <div class="col-md-4 mb-3">
                    <input class="form-control border border-secondary" placeholder="First name" name="u_fname"
                      type="text" value="<?php echo $parent['u_fname']; ?>" required minlength="3" maxlength="20"
                      pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>
                  <div class="col-md-4 mb-3">
                    <input class="form-control border border-secondary" placeholder="Middle name" name="u_m_name"
                      type="text" value="<?php echo $parent['u_m_name']; ?>" required minlength="3" maxlength="20"
                      pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>
                  <div class="col-md-4 mb-3">
                    <input class="form-control border border-secondary" placeholder="Last name" name="u_lname"
                      type="text" value="<?php echo $parent['u_lname']; ?>" required minlength="3" maxlength="20"
                      pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-5">
                    <div class="input-group mb-3">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          +63
                        </span>
                      </div>
                      <input class="form-control border border-secondary" id="contact_no" name="contact_no" type="text"
                        placeholder="9912367..." value="<?php echo $parent['contact_no']; ?>" placeholder="991236...."
                        oninput="contactInput(event)" required minlength="10" maxlength="10" pattern="\d{10}">
                    </div>
                  </div>
                  <div class="col-md-7 mb-3">
                    <input class="form-control border border-secondary" id="email" name="email" type="text"
                      value="<?php echo $parent['email']; ?>" placeholder="Input gmail" required minlength="11"
                      maxlength="50">
                  </div>

                  <div class="col-md-12 mb-4">
                    <!-- <p class="text-secondary text-center">Relationship with child</p> -->
                    <select name="relationship" id="relationshipSelect" class="form-control" required>
                      <option value="<?php echo $parent['relationship']; ?>" selected="">
                        <?php echo $parent['relationship']; ?>
                      </option>
                      <option value="" disabled>Relationship with child</option>
                      <option value="Father">Father</option>
                      <option value="Mother">Mother</option>
                      <option value="Other">Other...</option>
                    </select>

                    <!-- Hidden input field for 'Other' relationship -->
                    <input type="text" id="otherInput" name="other_relationship" class="form-control mt-3"
                      placeholder="Please specify" minlength="5" maxlength="30" pattern="[A-Za-z\s]+"
                      title="Only alphabetic characters are allowed" style="display: none;">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <!-- <div class="col-md-12 mt-5 mb-3 text-dark text-center">Address</div> -->
                  <div class="col-md-6 mb-3">
                    <input class="form-control border border-secondary" name="barangay" type="text"
                      value="<?php echo $parent['barangay']; ?>" placeholder="Input barangay" required minlength="3"
                      maxlength="30">
                  </div>
                  <div class="col-md-6 mb-3">
                    <input class="form-control border border-secondary" name="street" type="text"
                      value="<?php echo $parent['street']; ?>" placeholder="Input street or purok" required
                      minlength="3" maxlength="30">
                  </div>
                  <div class="col-md-6 mb-3">
                    <input class="form-control border border-secondary" name="city" type="text"
                      value="<?php echo $parent['city']; ?>" placeholder="Input city or municipality" required
                      minlength="3" maxlength="30" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>
                  <div class="col-md-6 mb-3">
                    <input class="form-control border border-secondary" name="state" type="text"
                      value="<?php echo $parent['state']; ?>" placeholder="Input state" required minlength="3"
                      maxlength="30" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>
                  <div class="col-md-6 mb-3">
                    <input class="form-control border border-secondary" name="zipcode" type="text"
                      value="<?php echo $parent['zipcode']; ?>" placeholder="Input zipcode" pattern="\d+"
                      title="Only numbers are allowed" required minlength="4" maxlength="4">
                  </div>
                </div>
              </div>
            </div>
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

<!-- script to handle if the relationship otherInput -->
<script>
  const relationshipSelect = document.getElementById('relationshipSelect');
  const otherInput = document.getElementById('otherInput');

  relationshipSelect.addEventListener('change', function () {
    if (this.value === 'Other') {
      otherInput.style.display = 'block'; // Show the input field
      otherInput.required = true; // Make it required when shown
      relationshipSelect.required = false; // Make it required when shown
      relationshipSelect.name = ''; // Remove name from the select field
      otherInput.name = 'relationship'; // Set 'relationship' as the name for the input
    } else {
      otherInput.style.display = 'none'; // Hide the input field
      otherInput.required = false; // Remove required when hidden
      relationshipSelect.required = true;
      otherInput.value = ''; // Clear the input field
      relationshipSelect.name = 'relationship'; // Restore the name of the select field
      otherInput.name = 'other_relationship'; // Clear the name of the input
    }
  });
</script>

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