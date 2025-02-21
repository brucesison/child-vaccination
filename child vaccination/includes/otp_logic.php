<?php
session_start();
require "connection.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$email = "";
$name = "";
$errors = array();

// Parent forgot pass
//if parent click continue button in forgot password form
if (isset($_POST['check-parent-email'])) {
  $email = mysqli_real_escape_string($connection, $_POST['email']);
  $check_email = "SELECT * FROM user_tbl WHERE email= '$email'";
  $run_sql = mysqli_query($connection, $check_email);
  if (mysqli_num_rows($run_sql) > 0) {
    $code = rand(999999, 111111);
    $insert_code = "UPDATE user_tbl SET code = $code WHERE email = '$email'";
    $run_query = mysqli_query($connection, $insert_code);
    if ($run_query) {

      $mail = new PHPMailer(true);
      try {
        //Server settings
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'deng36553@gmail.com';                 // SMTP username
        $mail->Password = 'nbkq zdwh wrfv hcjq';                  // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('deng36553@gmail.com', "Children's Clinic");
        $mail->addAddress($email, 'Recipient');    // Add a recipient

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = 'Password Reset Code';
        $mail->Body = 'Your password reset code is ' . $code;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        $info = "We've sent a verification code to your email –" . $email;
        $_SESSION['info'] = $info;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        header('location: reset_code.php');
        exit();
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    } else {
      $errors['db-error'] = "Something went wrong!";
    }
  } else {
    $errors['email'] = "This email address does not exist!";
  }
}

//if parent click check reset otp button
if (isset($_POST['check-reset-otp'])) {
  $_SESSION['info'] = "";
  $otp_code = mysqli_real_escape_string($connection, $_POST['otp']);
  $check_code = "SELECT * FROM user_tbl WHERE code = $otp_code";
  $code_res = mysqli_query($connection, $check_code);
  if (mysqli_num_rows($code_res) > 0) {
    $fetch_data = mysqli_fetch_assoc($code_res);
    $email = $fetch_data['email'];
    $_SESSION['email'] = $email;
    $info = "Please create a new password that you don't use on any other site.";
    $_SESSION['info'] = $info;
    header('location: new_password.php');
    exit();
  } else {
    $errors['otp-error'] = "You've entered incorrect code!";
  }
}

//if parent click change password button
if (isset($_POST['change-password'])) {
  $_SESSION['info'] = "";
  $password = mysqli_real_escape_string($connection, $_POST['pass']);
  $cpassword = mysqli_real_escape_string($connection, $_POST['cpassword']);
  if ($password !== $cpassword) {
    $errors['pass'] = "Confirm password not matched!";
  } else {
    $code = 0;
    $email = $_SESSION['email']; //getting this email using session
    $encpass = md5($password);
    $update_pass = "UPDATE user_tbl SET code = $code, pass = '$encpass' WHERE email = '$email'";
    $run_query = mysqli_query($connection, $update_pass);
    if ($run_query) {
      $info = "Your password changed. Now you can login with your new password.";
      $_SESSION['info'] = $info;
      header('Location: password_changed.php');
    } else {
      $errors['db-error'] = "Failed to change your password!";
    }
  }
}


// Secretary forgot pass
//if user click continue button in forgot password form
if (isset($_POST['check-secretary-email'])) {
  $email = mysqli_real_escape_string($connection, $_POST['email']);
  $check_email = "SELECT * FROM staff_tbl WHERE user_type = 'secretary' AND email= '$email'";
  $run_sql = mysqli_query($connection, $check_email);
  if (mysqli_num_rows($run_sql) > 0) {
    $code = rand(999999, 111111);
    $insert_code = "UPDATE staff_tbl SET code = $code WHERE email = '$email'";
    $run_query = mysqli_query($connection, $insert_code);
    if ($run_query) {

      $mail = new PHPMailer(true);
      try {
        //Server settings
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'deng36553@gmail.com';                 // SMTP username
        $mail->Password = 'nbkq zdwh wrfv hcjq';                  // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('deng36553@gmail.com', "Children's Clinic");
        $mail->addAddress($email, 'Recipient');    // Add a recipient

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = 'Password Reset Code';
        $mail->Body = 'Your password reset code is ' . $code;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        $info = "We've sent a verification code to your email –" . $email;
        $_SESSION['info'] = $info;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        header('location: reset_code2.php');
        exit();
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    } else {
      $errors['db-error'] = "Something went wrong!";
    }
  } else {
    $errors['email'] = "This email address does not exist!";
  }
}

//if secretary click check reset otp button
if (isset($_POST['check-secretary-reset-otp'])) {
  $_SESSION['info'] = "";
  $otp_code = mysqli_real_escape_string($connection, $_POST['otp']);
  $check_code = "SELECT * FROM staff_tbl WHERE user_type = 'secretary' AND code = $otp_code";
  $code_res = mysqli_query($connection, $check_code);
  if (mysqli_num_rows($code_res) > 0) {
    $fetch_data = mysqli_fetch_assoc($code_res);
    $email = $fetch_data['email'];
    $_SESSION['email'] = $email;
    $info = "Please create a new password that you don't use on any other site.";
    $_SESSION['info'] = $info;
    header('location: new_password2.php');
    exit();
  } else {
    $errors['otp-error'] = "You've entered incorrect code!";
  }
}

//if secretary change password button
if (isset($_POST['change-secretary-password'])) {
  $_SESSION['info'] = "";
  $password = mysqli_real_escape_string($connection, $_POST['pass']);
  $cpassword = mysqli_real_escape_string($connection, $_POST['cpassword']);
  if ($password !== $cpassword) {
    $errors['pass'] = "Confirm password not matched!";
  } else {
    $code = 0;
    $email = $_SESSION['email']; //getting this email using session
    $encpass = md5($password);
    $update_pass = "UPDATE staff_tbl SET code = $code, pass = '$encpass' WHERE email = '$email'";
    $run_query = mysqli_query($connection, $update_pass);
    if ($run_query) {
      $info = "Your password changed. Now you can login with your new password.";
      $_SESSION['info'] = $info;
      header('Location: password_changed2.php');
    } else {
      $errors['db-error'] = "Failed to change your password!";
    }
  }
}

// Admin forgot pass
//if admin click continue button in forgot password form
if (isset($_POST['check-admin-email'])) {
  $email = mysqli_real_escape_string($connection, $_POST['email']);
  $check_email = "SELECT * FROM staff_tbl WHERE user_type = 'doctor' AND email= '$email'";
  $run_sql = mysqli_query($connection, $check_email);
  if (mysqli_num_rows($run_sql) > 0) {
    $code = rand(999999, 111111);
    $insert_code = "UPDATE staff_tbl SET code = $code WHERE email = '$email'";
    $run_query = mysqli_query($connection, $insert_code);
    if ($run_query) {

      $mail = new PHPMailer(true);
      try {
        //Server settings
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'deng36553@gmail.com';                 // SMTP username
        $mail->Password = 'nbkq zdwh wrfv hcjq';                  // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('deng36553@gmail.com', "Children's Clinic");
        $mail->addAddress($email, 'Recipient');    // Add a recipient

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = 'Password Reset Code';
        $mail->Body = 'Your password reset code is ' . $code;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        $info = "We've sent a verification code to your email –" . $email;
        $_SESSION['info'] = $info;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        header('location: reset_code3.php');
        exit();
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    } else {
      $errors['db-error'] = "Something went wrong!";
    }
  } else {
    $errors['email'] = "This email address does not exist!";
  }
}

//if admin click check reset otp button
if (isset($_POST['check-admin-reset-otp'])) {
  $_SESSION['info'] = "";
  $otp_code = mysqli_real_escape_string($connection, $_POST['otp']);
  $check_code = "SELECT * FROM staff_tbl WHERE user_type = 'doctor' AND code = $otp_code";
  $code_res = mysqli_query($connection, $check_code);
  if (mysqli_num_rows($code_res) > 0) {
    $fetch_data = mysqli_fetch_assoc($code_res);
    $email = $fetch_data['email'];
    $_SESSION['email'] = $email;
    $info = "Please create a new password that you don't use on any other site.";
    $_SESSION['info'] = $info;
    header('location: new_password3.php');
    exit();
  } else {
    $errors['otp-error'] = "You've entered incorrect code!";
  }
}

//if admin change password button
if (isset($_POST['change-admin-password'])) {
  $_SESSION['info'] = "";
  $password = mysqli_real_escape_string($connection, $_POST['pass']);
  $cpassword = mysqli_real_escape_string($connection, $_POST['cpassword']);
  if ($password !== $cpassword) {
    $errors['pass'] = "Confirm password not matched!";
  } else {
    $code = 0;
    $email = $_SESSION['email']; //getting this email using session
    $encpass = md5($password);
    $update_pass = "UPDATE staff_tbl SET code = $code, pass = '$encpass' WHERE email = '$email'";
    $run_query = mysqli_query($connection, $update_pass);
    if ($run_query) {
      $info = "Your password changed. Now you can login with your new password.";
      $_SESSION['info'] = $info;
      header('Location: password_changed3.php');
    } else {
      $errors['db-error'] = "Failed to change your password!";
    }
  }
}


?>