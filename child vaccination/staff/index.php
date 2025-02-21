<?php

@include "includes/db_connect.php";
require "includes/functions.php";

session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_loggedin']) && !isset($_SESSION['secretary_loggedin'])) {
    header("Location: access_denied.php");
    exit;
} else {
    $staff_id = $_SESSION["staff_id"];
    $staff_name = $_SESSION["staff_name"];

    $staff_info = $functions->staffInfo($staff_id);

    $unique_id = $staff_info['unique_id'];

    $status = $_GET['status'] ?? '';

    $user_type = $staff_info['user_type'];
    $dashboard_name = 'Admin Dashboard';
    $admin_access = '';
    if ($user_type == 'secretary') {
        $dashboard_name = 'Secretary Dashboard';
        $admin_access = 'd-none';
    }

    $request = $functions->getRequestCount();
    $upcoming = $functions->getUpcomingCount();
    $today_appointment = $functions->getTodayUpcoming();
    $child = $functions->getCountChild();
    $parent = $functions->getCountParent();
    $secretary = $functions->getCountSecretary();
    $admin = $functions->getCountAdmin();
    $not_verified = $functions->getPendingParentCount();

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
    <title><?php echo $dashboard_name ?></title>
    <link rel="icon" href="../includes/icon/favicon.ico">
    <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

    <?php if ($status == 'loggedin'):
        include './includes/page_loader.php'; ?>
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-main shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- Hidden audio element -->
                    <audio id="notificationSound" src="new_request.mp3"></audio>

                    <!-- Content Row -->
                    <?php include './includes/dashboard_contents.php'; ?>

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

    <!-- Script to display realtime notif badge in appointment tab -->
    <script src="check/check_badge.js"></script>

    <script>
        let lastCount = 0;

        function checkForNewRequests() {
            $.ajax({
                url: 'check/check_new_app.php', // PHP file to get the count
                method: 'GET',
                success: function (response) {
                    const count = parseInt(response, 10); // Parse response to an integer

                    // Update the displayed count
                    $('#appointmentCount').text(count);

                    lastCount = count; // Update last count
                }
            });
        }

        // Check for new requests every 5 seconds
        setInterval(checkForNewRequests, 2000);
    </script>
</body>

</html>