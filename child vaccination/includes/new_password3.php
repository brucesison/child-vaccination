<?php require_once "otp_logic.php"; ?>
<?php
$email = $_SESSION['email'];
if ($email == false) {
  header('Location: admin_login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create a New Password</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include 'libraries.php'; ?>
</head>

<body class="forgot_pass">
  <div class="container">
    <div class="row p-3 align-items-center justify-content-center" style="height: 100vh;">
      <div class="col-md-4 bg-light shadow border border-gray p-5">
        <form action="new_password3.php" method="POST" autocomplete="off">
          <h2 class="text-center text-dark">New Password</h2>
          <?php
          if (isset($_SESSION['info'])) {
            ?>
            <div class="small alert alert-success text-center">
              <?php echo $_SESSION['info']; ?>
            </div>
            <?php
          }
          ?>
          <?php
          if (count($errors) > 0) {
            ?>
            <div class="small alert alert-danger text-center">
              <?php
              foreach ($errors as $showerror) {
                echo $showerror;
              }
              ?>
            </div>
            <?php
          }
          ?>
          <div class="input-group mb-3">
            <input class="form-control" id="pass" name="pass" type="password" placeholder="Create new password"
              autocomplete="off" required>
            <div class="input-group-append rounded-right ">
              <span class="input-group-text">
                <i class="fas fa-eye text-main" id="pass-toggle"></i>
              </span>
            </div>
          </div>
          <div id="password-strength-alert" class="text-danger mt-2" style="display: none;">Password must be at
            least 8 characters long and contain at least one number, and one special character.</div>
          <div class="input-group mb-3">
            <input class="form-control" id="cpass" name="cpassword" type="password" placeholder="Confirm your password"
              autocomplete="off" required>
            <div class="input-group-append rounded-right ">
              <span class="input-group-text">
                <i class="fas fa-eye text-main" id="cpass-toggle"></i>
              </span>
            </div>
          </div>
          <div id="password-match-alert" class="text-danger my-2" style="display: none;">Passwords do not match
          </div>
          <!-- <div class="form-group">
            <input class="form-control" type="password" name="pass" placeholder="Create new password" required>
          </div>
          <div class="form-group">
            <input class="form-control" type="password" name="cpassword" placeholder="Confirm your password" required>
          </div> -->
          <div class="form-group">
            <input class="form-control button btn-main mb-3" type="submit" id="submit-pass" name="change-admin-password"
              value="Change">
            <a href="reset_otp3.php?email=<?php echo $email ?>" class="btn btn-outline-main col-12">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- script to handle password visibility and strength  -->
  <script>
    document.getElementById('cpass').addEventListener('input', validatePasswords);
    document.getElementById('pass').addEventListener('input', validatePasswords);
    document.getElementById('pass-toggle').addEventListener('click', togglePasswordVisibility);
    document.getElementById('cpass-toggle').addEventListener('click', togglePasswordVisibility);

    function validatePasswords() {
      var pass = document.getElementById('pass').value;
      var cpass = document.getElementById('cpass').value;
      var matchAlert = document.getElementById('password-match-alert');
      var strengthAlert = document.getElementById('password-strength-alert');
      var registerButton = document.getElementById('submit-pass');

      var passwordValid = validatePasswordStrength(pass);

      if (!passwordValid) {
        strengthAlert.style.display = 'block';
        registerButton.disabled = true;
      } else {
        strengthAlert.style.display = 'none';
      }

      if (cpass !== pass) {
        matchAlert.style.display = 'block';
        registerButton.disabled = true;
      } else {
        matchAlert.style.display = 'none';
      }

      if (passwordValid && cpass === pass) {
        registerButton.disabled = false;
      }
    }

    function validatePasswordStrength(password) {
      var regex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
      return regex.test(password);
    }

    function togglePasswordVisibility() {
      var passwordField = this.parentElement.parentElement.previousElementSibling;
      if (passwordField.type === "password") {
        passwordField.type = "text";
      } else {
        passwordField.type = "password";
      }
    }
  </script>

</body>

</html>