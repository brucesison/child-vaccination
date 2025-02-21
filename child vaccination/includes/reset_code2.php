<?php require_once "otp_logic.php"; ?>
<?php
$email = $_SESSION['email'];
if ($email == false) {
  header('Location: secretary_login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Code Verification</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include 'libraries.php'; ?>
</head>

<body class="forgot_pass">
  <div class="container-fluid">
    <div class="row p-3 align-items-center justify-content-center" style="height: 100vh;">
      <div class="col-md-4 bg-light shadow border border-gray p-5">
        <form action="reset_code2.php" method="POST" autocomplete="off">
          <h2 class="text-center text-dark">Code Verification</h2>
          <?php
          if (isset($_SESSION['info'])) {
            ?>
            <div class="alert alert-success text-center" style="padding: 0.4rem 0.4rem">
              <?php echo $_SESSION['info']; ?>
            </div>
            <?php
          }
          ?>
          <?php
          if (count($errors) > 0) {
            ?>
            <div class="alert alert-danger text-center">
              <?php
              foreach ($errors as $showerror) {
                echo $showerror;
              }
              ?>
            </div>
            <?php
          }
          ?>
          <div class="form-group">
            <input class="form-control" type="number" name="otp" placeholder="Enter code" required>
          </div>
          <div class="form-group">
            <input class="form-control btn btn-main mb-3" type="submit" name="check-secretary-reset-otp" value="Submit">
            <a href="reset_otp2.php?email=<?php echo $email ?>" class="btn btn-outline-main col-12">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>

</html>