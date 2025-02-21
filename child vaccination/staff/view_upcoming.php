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

    if (isset($_GET['appointment_id'])) {
        $upcoming = $functions->getThisUpcomingAppointment($_GET['appointment_id']);
    }

    // get the status of the submitted form (success/error)
    $status = $_GET['status'] ?? '';

    // Get the current script name
    $current_page = basename($_SERVER['PHP_SELF']);
    $active_appointment = '';

    if ($current_page == 'view_upcoming.php') {
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
    <title>View Upcoming Appointment</title>
    <link rel="icon" href="../includes/icon/favicon.ico">
    <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

    <!-- check if form is submitted successfully -->
    <?php if ($status == 'resched_success'): ?>
        <script>
            Swal.fire({
                title: "",
                text: "Appointment rescheduled!",
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

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-light small shadow">
                            <li class="breadcrumb-item"><a class="text-main" href="app_upcoming.php">Upcoming
                                    Appointment</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Upcoming Appointment</li>
                        </ol>
                    </nav>

                    <!-- Content Row -->
                    <div class="row mb-5 d-flex justify-content-between align-items-center h-100">
                        <div class="col-md-12 mb-4">
                            <div class="card shadow">
                                <div class="card-header">
                                    <!-- <div class="float-right dropdown no-arrow">
                                        <a class="dropdown-toggle" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Action:</div>
                                            <button class="dropdown-item" data-toggle="modal"
                                                data-target="#cancel_appointment">Cancel</button>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="card-body text-center">
                                    <div class="row px-4 d-flex justify-content-between align-items-center">
                                        <div class="col-md-6">
                                            <p class="text-secondary text-left"><span
                                                    class="font-weight-bold">Appointment Date</span> :
                                                <?php
                                                // Format the date to include the name of the month
                                                $f_date = date("l, F j, Y", strtotime($upcoming['appointment_date']));
                                                echo $f_date;
                                                ?>
                                            </p>
                                            <p class="text-secondary text-left"><span
                                                    class="font-weight-bold">Appointment Time</span> :
                                                <?php
                                                $app_time = json_decode($upcoming['appointment_time'], true);
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
                                            </p>
                                            <p class="text-secondary text-left"><span
                                                    class="font-weight-bold">Guardian's Name</span> :
                                                <?php echo $upcoming['guardian_name']; ?>
                                            </p>
                                            <p class="text-secondary text-left"><span class="font-weight-bold">Child's
                                                    Name</span> :
                                                <?php
                                                $child = json_decode($upcoming['child_name'], true);
                                                if (!empty($child)) {
                                                    foreach ($child as $childs) {
                                                        echo htmlspecialchars($childs) . ", ";
                                                    }
                                                } ?>
                                            </p>
                                            <p class="text-secondary text-left"><span class="font-weight-bold">Reason
                                                    for visit</span> :
                                                <?php
                                                $reason = json_decode($upcoming['reason_for_visit'], true);
                                                if (!empty($reason)) {
                                                    foreach ($reason as $reasons) {
                                                        echo htmlspecialchars($reasons) . ", ";
                                                    }
                                                } ?>
                                            </p>
                                            <button type="submit"
                                                class="shadow-sm btn btn-sm btn-main btn-with-sparkle float-left mr-2"
                                                data-toggle="modal" data-target="#mark_done">
                                                <i class="fas fa-fw fa-check mr-1"></i>Done
                                            </button>
                                            <button type="submit"
                                                class="shadow-sm btn btn-sm btn-info float-left text-light mr-2"
                                                data-toggle="modal" data-target="#re_schedule">
                                                <i class="fas fa-fw fa-calendar mr-1"></i>Re Schedule
                                            </button>
                                            <button type="submit"
                                                class="shadow-sm btn btn-sm btn-danger float-left text-light"
                                                data-toggle="modal" data-target="#cancel_appointment">
                                                Cancel
                                            </button>
                                            <!-- mark as done modal-->
                                            <?php include './modals/mark_done_modal.php'; ?>
                                            <!-- re schedule modal-->
                                            <?php include './modals/re_schedule_modal.php'; ?>
                                            <!-- cancel appointment modal -->
                                            <?php include './modals/cancel_upcoming_modal.php'; ?>
                                        </div>
                                        <div class="col-md-6" id="view-app-calendar">
                                            <?php include './img/calendar.svg'; ?>
                                        </div>
                                    </div>
                                </div>
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

    <!-- Custom scripts for sidebar and scrolling-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Script to display realtime notif badge in appointment tab -->
    <script src="check/check_badge.js"></script>

</body>

</html>