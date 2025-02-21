<div class="modal fade" id="add_parent" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-dark text-uppercase" id="exampleModalLabel">Add Parent</h5>
      </div>
      <form id="add_parent_form" action="add/add_parent.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body bg-light">
          <div class="container-fluid">
            <div class="row">

              <div class="col-md-12 mt-3 mb-4 text-dark text-center">Account Details</div>
              <div id="alertpic-area" class="col-md-12"></div>
              <div id="alert-area" class="col-md-12"></div>
              <div id="alert-area2" class="col-md-12"></div>
              <div id="alert-area3" class="col-md-12"></div>
              <!-- Account deltails -->
              <div class="col-md-6">
                <div class="row">

                  <div class="col-md-12 mb-3">
                    <p class="small mb-1 text-center">Parent profile picture</p>
                    <input class="col-md-12 p-1 rounded border border-secondary" type="file" name="profile_image"
                      accept="image/*" required>
                  </div>

                  <div class="col-md-4 mb-3">
                    <input class="form-control border border-secondary" placeholder="First name" name="u_fname"
                      type="text" required minlength="3" maxlength="15" pattern="[A-Za-z\s]+"
                      title="Only alphabetic characters are allowed">
                  </div>
                  <div class="col-md-4 mb-3">
                    <input class="form-control border border-secondary" placeholder="Middle name" name="u_m_name"
                      type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                      title="Only alphabetic characters are allowed">
                  </div>
                  <div class="col-md-4 mb-3">
                    <input class="form-control border border-secondary" placeholder="Last name" name="u_lname"
                      type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                      title="Only alphabetic characters are allowed">
                  </div>

                  <div class="input-group col-md-5 mb-3">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        +63
                      </span>
                    </div>
                    <input class="form-control border border-secondary" id="contact_no" name="contact_no" type="text"
                      placeholder="Input contact no." placeholder="991236...." oninput="contactInput(event)" required
                      minlength="10" maxlength="10" pattern="\d{10}"
                      title="Please input 10 digits number that starts with 9">
                  </div>
                  <div class="col-md-7 mb-3">
                    <input class="form-control border border-secondary" id="email" name="email" type="email"
                      placeholder="Input gmail" required minlength="13" maxlength="50">
                  </div>

                  <!-- <div class="col-md-4 mb-3">
                    <input class="form-control border border-secondary" id="a_pass" name="pass" type="text"
                      placeholder="Input password" required>
                    <div id="password-strength-alert" class="text-danger mt-2" style="display: none;">Password must be
                      at least 8 characters long and contain at least one number, and one special character.</div>
                  </div> -->

                  <div class="col-md-6">
                    <div class="input-group mb-3">
                      <input class="form-control" id="pass" name="pass" type="password" placeholder="Password" required>
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="fas fa-eye" id="pass-toggle" style="cursor: pointer;"></i>
                        </span>
                      </div>
                    </div>
                    <div id="password-strength-alert" class="text-danger mt-2" style="display: none;">
                      Password must be at least 8 characters long and contain at least one number, and one special
                      character.
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="input-group mb-3">
                      <input class="form-control" id="cpass" name="cpass" type="password" placeholder="Confirm password"
                        required>
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="fas fa-eye" id="cpass-toggle" style="cursor: pointer;"></i>
                        </span>
                      </div>
                    </div>
                    <div id="password-match-alert" class="text-danger mt-2" style="display: none;">
                      Passwords do not match
                    </div>
                  </div>

                  <div class="col-md-12 mb-3">
                    <!-- <p class="text-secondary text-center">Relationship with child</p> -->
                    <select name="relationship" id="relationshipSelect" class="form-control border-secondary" required>
                      <option value="" selected="" disabled>Relationship with child</option>
                      <option value="Father">Father</option>
                      <option value="Mother">Mother</option>
                      <option value="Other">Other...</option>
                    </select>

                    <!-- Hidden input field for 'Other' relationship -->
                    <input type="text" id="otherInput" name="other_relationship" class="form-control mt-3"
                      placeholder="Please specify" style="display: none;">
                  </div>
                </div>
              </div>

              <!-- Address -->
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <p class="small mb-1 text-center">Address</p>
                  </div>
                  <div class="col-md-12 mb-3">
                    <input class="form-control border border-secondary" name="barangay" type="text"
                      placeholder="Input barangay" required minlength="3" maxlength="30">
                  </div>
                  <div class="col-md-12 mb-3">
                    <input class="form-control border border-secondary" name="street" type="text"
                      placeholder="Input street or purok" required minlength="3" maxlength="30">
                  </div>
                  <div class="col-md-12 mb-3">
                    <input class="form-control border border-secondary" name="city" type="text"
                      placeholder="Input city or municipality" required minlength="3" maxlength="30"
                      pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>
                  <div class="col-md-12 mb-3">
                    <input class="form-control border border-secondary" name="state" type="text"
                      placeholder="Input province" required minlength="3" maxlength="30" pattern="[A-Za-z\s]+"
                      title="Only alphabetic characters are allowed">
                  </div>
                  <div class="col-md-12 mb-3">
                    <input class="form-control border border-secondary" name="zipcode" type="text"
                      placeholder="Input zipcode" pattern="\d+" title="Only numbers are allowed" required minlength="4"
                      maxlength="4">
                  </div>

                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-main" id="add-btn">
            <i class="fas fa-fw fa-plus mr-1"></i>Add
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

<!-- script to handle invalid inputs -->
<script>

  let isImageValid = false;
  let isContactValid = false;
  let isEmailValid = false;
  let isPasswordValid = false;
  let isPasswordMatch = false;

  // Function to update button state
  function updateAddButtonState() {
    const addButton = document.getElementById('add-btn');
    // Enable the button only if all fields are valid
    if (isImageValid && isContactValid && isEmailValid && isPasswordValid && isPasswordMatch) {
      addButton.disabled = false;
    } else {
      addButton.disabled = true;
    }
  }

  function validateFileUploads() {
    const profile_image = document.querySelector('input[name="profile_image"]');
    const alertpicArea = document.getElementById('alertpic-area');
    const maxFileSize = 2 * 1024 * 1024; // Set max file size to 2MB

    alertpicArea.innerHTML = '';
    isImageValid = true; // Assume valid by default

    // Validate image file type and size
    if (profile_image.files.length > 0) {
      const fileType = profile_image.files[0].type;
      const fileSize = profile_image.files[0].size;
      if (!fileType.startsWith('image/')) {
        alertpicArea.innerHTML = '<div class="alert alert-danger">Picture must be an image type file.</div>';
        isImageValid = false;
      }
      if (fileSize > maxFileSize) {
        alertpicArea.innerHTML = '<div class="alert alert-danger">Picture must be less than 2MB.</div>';
        isImageValid = false;
      }
    }

    updateAddButtonState();
  }

  document.querySelector('input[name="profile_image"]').addEventListener('change', validateFileUploads);

  $(document).ready(function () {
    $('#contact_no').on('input', function () {
      var contact_no = $('#contact_no').val();
      var alertArea = $('#alert-area');
      var alertArea2 = $('#alert-area2');

      // Clear previous alerts
      alertArea.empty();
      alertArea2.empty();
      isContactValid = true;

      $.ajax({
        type: 'POST',
        url: './check/check_all_contact.php',
        data: {
          contact_no: contact_no
        },
        success: function (response) {
          response = response.trim();

          // Contact number validation
          if (contact_no.startsWith('0') || contact_no.startsWith('1') || contact_no.startsWith('2') || contact_no.startsWith('3') || contact_no.startsWith('4') || contact_no.startsWith('5') || contact_no.startsWith('6') || contact_no.startsWith('7') || contact_no.startsWith('8')) {
            alertArea.html('<div class="alert alert-danger">Please enter a valid contact number.</div>');
            isContactValid = false;
          } if (response === 'exist') {
            alertArea2.html('<div class="col-md-12 alert alert-danger">Contact number is already in use!</div>');
            isContactValid = false;
          }

          // Update button state based on all validations
          updateAddButtonState();
        }
      });
    });
  });

  $(document).ready(function () {
    $('#email').on('input', function () {
      var email = $('#email').val();
      var alertArea3 = $('#alert-area3');

      // Clear previous alerts
      alertArea3.empty();
      isEmailValid = true;

      $.ajax({
        type: 'POST',
        url: './check/check_all_email.php',
        data: {
          email: email
        },
        success: function (response) {
          response = response.trim();

          // email validation
          if (response === 'exist') {
            alertArea3.html('<div class="col-md-12 alert alert-danger">Gmail is already in use!</div>');
            isEmailValid = false;
          }

          // Update button state based on all validations
          updateAddButtonState();
        }
      });
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
    var passInput = document.getElementById('pass');
    var cpassInput = document.getElementById('cpass');
    var passToggle = document.getElementById('pass-toggle');
    var cpassToggle = document.getElementById('cpass-toggle');
    var passwordStrengthAlert = document.getElementById('password-strength-alert');
    var passwordMatchAlert = document.getElementById('password-match-alert');
    var addButton = document.getElementById('add-btn'); // Assuming you want to disable the add button

    // Password validation regex (at least 8 characters, 1 number, 1 special character)
    var passwordRegex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;

    // Event listener for password input
    passInput.addEventListener('input', function () {
      var password = passInput.value;

      // Validate password strength
      if (!passwordRegex.test(password)) {
        passwordStrengthAlert.style.display = 'block';
        isPasswordValid = false;
      } else {
        passwordStrengthAlert.style.display = 'none';
        isPasswordValid = true;
      }

      // Also check if the passwords match
      validatePasswordMatch();
      updateAddButtonState();
    });

    // Event listener for confirm password input
    cpassInput.addEventListener('input', function () {
      validatePasswordMatch();
      updateAddButtonState();
    });

    // Toggle password visibility for 'pass' field
    passToggle.addEventListener('click', function () {
      togglePasswordVisibility(passInput, passToggle);
    });

    // Toggle password visibility for 'cpass' field
    cpassToggle.addEventListener('click', function () {
      togglePasswordVisibility(cpassInput, cpassToggle);
    });

    // Function to validate password match
    function validatePasswordMatch() {
      if (passInput.value !== cpassInput.value) {
        passwordMatchAlert.style.display = 'block';
        isPasswordMatch = false;
      } else {
        passwordMatchAlert.style.display = 'none';
        isPasswordMatch = true;
      }
    }

    // Function to toggle password visibility
    function togglePasswordVisibility(inputField, toggleIcon) {
      if (inputField.type === 'password') {
        inputField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
      } else {
        inputField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
      }
    }
  });

</script>

<!-- script to handle invalid gmail input -->
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

<!-- script to handle add-btn proccess  -->
<script>
  $(document).ready(function () {
    $('#add-btn').click(function (event) {
      // Prevent the default form submission
      event.preventDefault();

      // Validate form inputs using browser's built-in validation
      var form = document.getElementById('add_parent_form');

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