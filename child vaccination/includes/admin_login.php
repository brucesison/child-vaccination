<?php

@include 'db_connect.php';

$error = '';

session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_loggedin'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Get input data
        $email = $_POST['email'];
        $pass = md5($_POST['pass']);

        // Prepare the SQL statement using PDO
        $select = "SELECT * FROM staff_tbl WHERE email = :email AND pass = :pass AND user_type = 'doctor' AND user_type = 'super_admin'";

        // Prepare the statement
        $stmt = $pdo->prepare($select);

        // Execute the statement with input parameters
        $stmt->execute(['email' => $email, 'pass' => $pass]);

        // Check if user exists
        if ($stmt->rowCount() > 0) {
            $status = "Active now";
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set session variables
            $_SESSION['admin_loggedin'] = true;
            $_SESSION['staff_id'] = $row['staff_id'];
            $_SESSION['staff_name'] = $row['a_fname'] . ' ' . $row['a_m_initial'] . ' ' . $row['a_lname'];
            $_SESSION['unique_id'] = $row['unique_id'];

            // Update user status in the database
            $update = "UPDATE staff_tbl SET session_status = :status WHERE unique_id = :unique_id";
            $update_stmt = $pdo->prepare($update);
            $update_stmt->execute(['status' => $status, 'unique_id' => $row['unique_id']]);

            // Redirect to the parent index page
            header('location: ../staff/index.php?status=loggedin');
            exit;
        } else {
            // Show error message if credentials are incorrect
            $error = '
             <div class="alert alert-danger alert-dismissible fade show" role="alert">
                 <strong>Wrong email or password</strong>
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
           ';
        }
    }

} else {
    // If already logged in, redirect to the admin index page
    header("Location: ../staff/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Admin Login</title>
    <link rel="icon" href="../includes/icon/favicon.ico">
    <?php include 'libraries.php'; ?>
</head>

<body id="page-top" class="login_body">
    <div class="container-fluid px-4 pt-4">
        <div class="row p-3 align-items-center justify-content-center" style="height: 100vh;">
            <div
                class="col-md-5 bg-light pt-5 border rounded shadow d-flex align-items-center justify-content-center container-relative">
                <form id="login_form" method="POST" action="" class="m-0">
                    <div class="d-flex justify-content-center mb-4">
                        <img class="rounded-circle logo-signin" src="../staff/img/Clinic logo.png" alt="...">
                    </div>
                    <p class="col-md-12 text-center text-dark text-uppercase fs-3 font-weight-bold">SIGN IN to start
                        your session</p>
                    <?php echo $error; ?>
                    <div class="form-label-group">
                        <input type="text" class="form-control" placeholder="Email" id="email" name="email" required
                            minlength="13" maxlength="50">
                    </div>
                    <br>
                    <div class="input-group mb-5">
                        <input class="form-control" id="pass" name="pass" type="password" placeholder="Password"
                            autocomplete="off" required minlength="8">
                        <div class="input-group-append rounded-right ">
                            <span class="input-group-text">
                                <i class="fas fa-eye text-main" id="pass-toggle"></i>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <button type="submit" class="col-md-7 btn btn-outline-main btn-block font-weight-bold"
                            id="login-btn" value="Log in" title="Sign In">Sign In</button>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <a href="../index.php" class="col-md-7 btn btn-main btn-block font-weight-bold">Home</a>
                    </div>
                    <div class="text-center mb-3">
                        <a href="forgot_admin_pass.php" class="text-main small">Forgot password?</a>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('pass-toggle').addEventListener('click', togglePasswordVisibility);

        function togglePasswordVisibility() {
            var passwordField = this.parentElement.parentElement.previousElementSibling;
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
    <script>
        AOS.init();
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
            $('#login-btn').click(function (event) {
                // Prevent the default form submission
                event.preventDefault();

                // Validate form inputs using browser's built-in validation
                var form = document.getElementById('login_form');

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
</body>

</html>