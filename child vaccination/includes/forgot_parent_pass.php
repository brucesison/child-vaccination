<?php require_once "otp_logic.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include 'libraries.php'; ?>
</head>

<body class="forgot_pass">

  <div class="container-fluid">
    <div class="row p-3 align-items-center justify-content-center" style="height: 100vh;">
      <div class="col-md-4 bg-light shadow border border-gray p-5">
        <form id="forgot_form" action="forgot_parent_pass.php" method="POST" autocomplete="">
          <h2 class="text-center text-dark">Forgot Password</h2>
          <p class="text-center text-dark">Enter your email address</p>
          <?php
          if (count($errors) > 0) {
            ?>
            <div class="alert alert-danger text-center">
              <?php
              foreach ($errors as $error) {
                echo $error;
              }
              ?>
            </div>
            <?php
          }
          ?>
          <div class="form-group">
            <input class="form-control" type="email" id="email" name="email" placeholder="Enter email address" required
              value="<?php echo $email ?>">
          </div>
          <div class="form-group mb-4">
            <input class="form-control button btn-main" type="submit" name="check-parent-email" value="Continue">
          </div>
          <div class="col-md-12 text-center">
            Back to
            <a href="parent_login.php" class="text-main font-weight-bold">login</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

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

</html>