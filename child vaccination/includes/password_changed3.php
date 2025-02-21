<?php require_once "otp_logic.php"; ?>
<?php
if ($_SESSION['info'] == false) {
  header('Location: admin_login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include 'libraries.php'; ?>
</head>

<body class="forgot_pass">
  <div class="container">
    <div class="row p-3 align-items-center justify-content-center" style="height: 100vh;">
      <div class="col-md-4 bg-light shadow border border-gray p-5">
        <?php
        if (isset($_SESSION['info'])) {
          ?>
          <div class="small alert alert-success text-center">
            <?php echo $_SESSION['info']; ?>
          </div>
          <?php
        }
        ?>
        <form action="admin_login.php" method="POST">
          <div class="form-group">
            <input class="form-control btn-main" type="submit" name="login-now" value="Login Now">
          </div>
        </form>
      </div>
    </div>
  </div>

</body>

</html>