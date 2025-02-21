<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Account Registration</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include 'libraries.php'; ?>
</head>

<body id="page-top" class="register">
  <div class="container-fluid px-4 py-2">
    <div class="row h-100 align-items-center justify-content-center">
      <div
        class="col-md-5 bg-light pt-5 px-3 border shadow rounded d-flex align-items-center justify-content-center h-50">
        <form id="registration-form" action="admin_register.php" method="POST" enctype="multipart/form-data">

          <div class="row">
            <p class="col-md-12 text-center text-dark text-uppercase fs-3 font-weight-bold mb-3">Register Now!</p>
            <div id="alert-area" class="col-md-12"></div>
            <div id="alert-area2" class="col-md-12"></div>
            <div id="alert-area3" class="col-md-12"></div>

            <div class="col-md-12 mb-3">
              <div class="col-md-12 text-secondary mb-2 text-center">Account Details</div>

              <div class="form-group mb-4">
                <input type="text" class="form-control" name="s_fname" placeholder="First name..." required
                  minlength="3" maxlength="30" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
              </div>

              <div class="form-group mb-4">
                <input type="text" class="form-control" name="s_m_initial" placeholder="Middle name..." required
                  minlength="3" maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
              </div>

              <div class="form-group mb-4">
                <input type="text" class="form-control" name="s_lname" placeholder="Last name..." required minlength="4"
                  maxlength="30" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
              </div>

              <div class="form-group mb-4">
                <input type="email" class="form-control" id="email" name="email" placeholder="Gmail ..." required
                  minlength="7" maxlength="50" pattern="[a-zA-Z0-9._%+-]+@gmail\.com$"
                  title="Please enter a valid Gmail address (example@gmail.com)">
              </div>


              <div class="input-group mb-4">
                <div class="input-group-append">
                  <span class="input-group-text">
                    +63
                  </span>
                </div>
                <input class="form-control" id="contact_no" name="contact_no" type="text" placeholder="9912367..."
                  placeholder="991236...." oninput="contactInput(event)" required maxlength="10" pattern="\d{10}"
                  title="Please input 10 digits)">
              </div>

              <div class="input-group mb-4">
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

              <div class="input-group">
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

            <div id="alertpic-area" class="col-md-12"></div>
            <div class="col-md-12 mb-5">
              <p class="text-secondary text-center">Profile Picture</p>
              <div class="row">
                <div class="col-md-12">
                  <input class="col-md-12 p-1 form-control" type="file" name="staff_pic" accept="image/*" required>
                </div>
              </div>
            </div>

          </div>

          <div class="d-flex justify-content-center mb-3">
            <button type="submit" class="col-md-5 btn btn-main btn-block font-weight-bold"
              id="register-btn">Register</button>
          </div>

          <div class="text-center text-secondary mb-3 small">Already have an account?
            <a href="admin_login.php" class="text-main font-weight-bold">Login</a>
          </div>

        </form>
      </div>
    </div>
  </div>
  <?php include '../assets/proccess_loading.php'; ?>

  <!-- script to handle invalid inputs -->
  <script>

    let isProfileValid = false;
    let isContactValid = false;
    let isEmailValid = false;
    let isPasswordValid = false;
    let isPasswordMatch = false;

    // Function to update button state
    function updateAddButtonState() {
      const addButton = document.getElementById('register-btn');
      // Enable the button only if all fields are valid
      if (isProfileValid && isContactValid && isEmailValid && isPasswordValid && isPasswordMatch) {
        addButton.disabled = false;
      } else {
        addButton.disabled = true;
      }
    }

    function validateFileUploads() {
      const staff_pic = document.querySelector('input[name="staff_pic"]');
      const alertpicArea = document.getElementById('alertpic-area');
      const maxFileSize = 2 * 1024 * 1024; // Set max file size to 2MB

      alertpicArea.innerHTML = '';
      isProfileValid = true; // Assume valid by default

      // Validate image file type and size
      if (staff_pic.files.length > 0) {
        const fileType = staff_pic.files[0].type;
        const fileSize = staff_pic.files[0].size;
        if (!fileType.startsWith('image/')) {
          alertpicArea.innerHTML = '<div class="alert alert-danger">Picture must be an image type file.</div>';
          isProfileValid = false;
        }
        if (fileSize > maxFileSize) {
          alertpicArea.innerHTML = '<div class="alert alert-danger">Picture must be less than 2MB.</div>';
          isProfileValid = false;
        }
      }

      updateAddButtonState();
    }

    document.querySelector('input[name="staff_pic"]').addEventListener('change', validateFileUploads);

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
          url: '../staff/check/check_all_contact.php',
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
          url: '../staff/check/check_all_email.php',
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

  <!-- script to handle register-btn proccess  -->
  <script>
    $(document).ready(function () {
      $('#register-btn').click(function (event) {
        // Prevent the default form submission
        event.preventDefault();

        // Validate form inputs using browser's built-in validation
        var form = document.getElementById('registration-form');

        // Check if form is valid
        if (form.checkValidity() === false) {
          // If form is not valid, let the browser show validation errors
          form.reportValidity();
          return;
        }

        // If the form is valid, proceed to show loading animation and submit
        $('#loading-proccess').css('display', 'flex').fadeIn('fast');

        // Delay the form submission by 0.5 second
        setTimeout(function () {
          form.submit(); // Submit the form after the delay
        }, 500);
      });
    });
  </script>

</body>

</html>