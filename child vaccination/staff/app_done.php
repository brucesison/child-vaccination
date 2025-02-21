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

    $user_type = $staff_info['user_type'];
    $admin_access = 'd-none';
    if ($user_type == 'doctor') {
        $admin_access = '';
    }

    // get the status of the submitted form (success/error)
    $status = $_GET['status'] ?? '';

    $done = $functions->getDoneAppointment();

    $no_done_svg = 'd-none';
    $no_done = '';
    if (empty($done)) {
        $no_done = 'd-none';
        $no_done_svg = 'd-flex';
    }

    // Get the current script name
    $current_page = basename($_SERVER['PHP_SELF']);
    $active_appointment = '';

    if ($current_page == 'app_done.php') {

        // means dashboard menu is active
        $active_appointment = 'active';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Done Appointments</title>
    <link rel="icon" href="../includes/icon/favicon.ico">
    <?php include './libraries/libraries.php'; ?>

</head>

<body id="page-top">

    <!-- check if form is submitted successfully -->
    <?php if ($status == 'deleted_successfully'): ?>
        <script>
            Swal.fire({
                title: "Success",
                text: "Deleted successfully.",
                icon: "success",
                confirmButtonColor: "#009c95"
            });
        </script>
        <!-- else this page will load with page loader haha nice -->
    <?php elseif (!empty($done)):
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
                        <h1 class="h3 mb-0 text-gray-800">Done Appointment List</h1>
                    </div>

                    <div class="row my-5 <?php echo $no_done_svg; ?> align-items-center justify-content-center h-100">
                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                            <?php include 'img/no_data.svg'; ?>
                        </div>
                        <div class="col-md-12">
                            <h5 class="text-center">No done appointment found.</h5>
                        </div>
                    </div>

                    <!-- Data table Row -->
                    <div class="card shadow mb-4 <?php echo $no_done; ?>">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Child's Name</th>
                                            <th>Guardian's Name</th>
                                            <th>Reason for visit</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Child's Name</th>
                                            <th>Guardian's Name</th>
                                            <th>Reason for visit</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($done as $row) { ?>
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
                                                <td><?php echo ($row['guardian_name']); ?></td>
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
                                                <td>
                                                    <?php echo '
                                                        <a href="view_done.php?appointment_id=' . $row['appointment_id'] . '" class="btn btn-sm btn-main">
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

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                dom: 'lBfrtip',  // Places the buttons
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'  // Include hidden columns but exclude columns with class "no-export"
                        },
                        title: 'Data Export',
                        filename: 'Done List'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Export to PDF',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'  // Include hidden columns but exclude columns with class "no-export"
                        },
                        title: 'Data Export',
                        filename: 'Done List',
                        orientation: 'landscape',  // PDF layout (portrait or landscape)
                        pageSize: 'A4',  // PDF page size (A4, A5, etc.)
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'  // Include hidden columns but exclude columns with class "no-export"
                        },
                        title: 'Done List'
                    }
                ]
            });
        });
    </script>

    <!-- Custom scripts for sidebar and scrolling-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Script to display realtime notif badge in appointment tab -->
    <script src="check/check_badge.js"></script>

</body>

</html>