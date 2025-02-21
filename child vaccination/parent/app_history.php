<?php

@include "includes/db_connect.php";
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

    $my_child = $functions->showMyChild($parent_id);

    $app_history = $functions->showAppointmentHistory($parent_id);

    $unique_id = $parent_info['unique_id'];

    // Get the current script name
    $current_page = basename($_SERVER['PHP_SELF']);
    $appointment_menu = '';
    // Check if the current page is 'app_history.php'
    if ($current_page == 'app_history.php') {

        // means appointment menu is active
        $appointment_menu = 'active';
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Appointment History</title>
    <link rel="icon" href="../includes/icon/favicon.ico">
    <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

    <!-- page loader -->
    <?php include './includes/page_loader.php'; ?>

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
                <div class="container-fluid mb-5">

                    <!-- Page Heading -->
                    <div class="mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Appointment History</h1>
                    </div>

                    <?php if (!empty($app_history)) { ?>
                        <!-- Data table Row -->
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Child's Name</th>
                                                <th>Reason for visit</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Child's Name</th>
                                                <th>Reason for visit</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php foreach ($app_history as $row) { ?>
                                                <tr>
                                                    <td>
                                                        <?php // Format the date to include the name of the month
                                                                $f_date = date("F j, Y", strtotime($row['appointment_date']));
                                                                echo $f_date;
                                                                ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $app_time = json_decode($row['appointment_time'], true);
                                                        if (!empty($app_time) && is_array($app_time)) {
                                                            // Sort the time slots
                                                            sort($app_time);

                                                            // Get the start time (first element)
                                                            $start_time = $app_time[0];

                                                            // Calculate the end time (last element + 30 minutes)
                                                            $end_time = end($app_time);
                                                            $end_time_datetime = DateTime::createFromFormat('h:i A', $end_time);
                                                            $end_time_datetime->add(new DateInterval('PT30M'));
                                                            $formatted_end_time = $end_time_datetime->format('h:i A');

                                                            // Display the time range
                                                            $time_range = htmlspecialchars($start_time) . " to " . htmlspecialchars($formatted_end_time);
                                                            if ($time_range == '10:00 AM to 10:00 AM') {
                                                                echo '9:30 AM to 10:30 AM';
                                                            } else {
                                                                echo $time_range;
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $child = json_decode($row['child_name'], true);
                                                        if (!empty($child)) {
                                                            foreach ($child as $childs) {
                                                                echo htmlspecialchars($childs) . ", ";
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $reason = json_decode($row['reason_for_visit'], true);
                                                        if (!empty($reason)) {
                                                            foreach ($reason as $reasons) {
                                                                echo htmlspecialchars($reasons) . ", ";
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    $status = $row['status'];
                                                    $txt_color = '';
                                                    if ($status == 'Done') {
                                                        $txt_color = 'text-success';
                                                    } else if ($status == 'Rejected') {
                                                        $txt_color = 'text-danger';
                                                    } else if ($status == 'Cancelled') {
                                                        $txt_color = 'text-warning';
                                                    }
                                                    $capitalizedText = ucfirst($status);
                                                    echo '<td class="' . $txt_color . ' font-weight-bold">' . $capitalizedText . '</td>';
                                                    ?>
                                                    <td>
                                                        <?php echo '
                                                          <a href="view_history.php?appointment_id=' . $row['appointment_id'] . '" class="btn btn-sm btn-main">
                                                          <i class="fas fa-fw fa-eye mr-1"></i>View</a>'
                                                            ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row my-5 align-items-center justify-content-center h-100">
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <?php include 'img/no_data.svg'; ?>
                            </div>
                            <div class="col-md-12">
                                <h5 class="text-center">No appointment history yet.</h5>
                            </div>
                        </div>
                    <?php } ?>

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