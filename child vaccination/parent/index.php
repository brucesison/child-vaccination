<?php

include "includes/db_connect.php";
require "includes/functions.php";

session_start();

// Check if user is logged in
if (!isset($_SESSION['parent_loggedin'])) {
    header("Location: access_denied.php");
    exit;
} else {
    $parent_id = $_SESSION["parent_id"];
    $parent_name = $_SESSION["parent_name"];

    $parent_info = $functions->parentInfo($parent_id);
    $p_contact = $parent_info['contact_no'];
    $p_email = $parent_info['email'];

    $unique_id = $parent_info['unique_id'];

    $upcoming_app = $functions->showUpcomingApp($parent_id);

    // get the status of the submitted form (success/error)
    $status = $_GET['status'] ?? '';

    $no_app_content = 'd-none';
    $have_app_content = 'd-block';
    if (empty($upcoming_app)) {
        $no_app_content = 'd-block';
        $have_app_content = 'd-none';
    }

    // Get the current script name
    $current_page = basename($_SERVER['PHP_SELF']);
    $active = '';
    // Check if the current page is 'dashboard.php'
    if ($current_page == 'index.php') {

        // means dashboard menu is active
        $active = 'active';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home</title>
    <link rel="icon" href="../includes/icon/favicon.ico">
    <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

    <!-- check if form is submitted successfully -->
    <?php if ($status == 'cancelled'): ?>
        <script>
            Swal.fire({
                title: "",
                text: "Appointment cancelled!",
                icon: "success",
                confirmButtonColor: "#009c95"
            });
        </script>
    <?php endif; ?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include './includes/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include './includes/topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- <div class="mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Page Heading</h1>
                    </div> -->

                    <!-- Content Row -->
                    <div class="row mb-5 mt-3 d-flex justify-content-center h-100">
                        <?php include 'includes/home_content.php'; ?>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include './includes/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Custom scripts for sidebar and scrolling-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>