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
        $done = $functions->getThisDoneAppointment($_GET['appointment_id']);

        $appointment_date = $done['appointment_date'];
        $parent_id = $done['parent_id'];

        // Get all children for the parent
        $children = $functions->getFromChild($parent_id);

        // Initialize an array to store all findings
        $all_findings = [];
        $all_immunization = [];

        // Loop through each child to get their findings
        foreach ($children as $childid) {
            $child_id = $childid['child_id'];
            $findings = $functions->getAppointmentFHistory($appointment_date, $child_id);
            $immunization = $functions->getAppointmentVHistory($appointment_date, $child_id);

            // Merge findings with the main array
            $all_findings = array_merge($all_findings, $findings);

            // Merge immunization with the main array
            $all_immunization = array_merge($all_immunization, $immunization);
        }
    }

    // Get the current script name
    $current_page = basename($_SERVER['PHP_SELF']);
    $active_appointment = '';
    if ($current_page == 'view_done.php') {
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
    <title>View Done Appointment</title>
    <link rel="icon" href="../includes/icon/favicon.ico">
    <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

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
                            <li class="breadcrumb-item"><a class="text-main" href="app_done.php">Done Appointment</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">View Done Appointment</li>
                        </ol>
                    </nav>

                    <!-- Content Row -->
                    <div class="row my-5 d-flex justify-content-between align-items-center h-100">
                        <div class="col-md-12 mb-4">
                            <div class="card shadow">
                                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-main">Appointment details</h6>
                                    <div class="dropdown no-arrow <?php echo $admin_access; ?>">
                                        <a class="dropdown-toggle" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Action:</div>
                                            <!-- <a class="dropdown-item btn" data-toggle="modal" data-target="#delete_done">Delete</a> -->
                                            <button class="dropdown-item" data-toggle="modal"
                                                data-target="#del_done">Delete</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- delete done appointment modal-->
                                <?php include './modals/delete_done_modal.php'; ?>

                                <div class="card-body text-center">
                                    <div class="row px-4 d-flex justify-content-between align-items-center">
                                        <div class="col-md-6">
                                            <p class="text-secondary text-left"><span
                                                    class="font-weight-bold">Appointment Date</span> :
                                                <?php
                                                // Format the date to include the name of the month
                                                $f_date = date("l, F j, Y", strtotime($done['appointment_date']));
                                                echo $f_date;
                                                ?>
                                            </p>
                                            <p class="text-secondary text-left"><span
                                                    class="font-weight-bold">Appointment Time</span> :
                                                <?php
                                                $app_time = json_decode($done['appointment_time'], true);
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
                                                <?php echo $done['guardian_name']; ?>
                                            </p>
                                            <p class="text-secondary text-left"><span class="font-weight-bold">Child's
                                                    Name</span> :
                                                <?php
                                                $child = json_decode($done['child_name'], true);
                                                if (!empty($child)) {
                                                    foreach ($child as $childs) {
                                                        echo htmlspecialchars($childs) . ", ";
                                                    }
                                                } ?>
                                            </p>
                                            <p class="text-secondary text-left"><span class="font-weight-bold">Reason
                                                    for visit</span> :
                                                <?php
                                                $reason = json_decode($done['reason_for_visit'], true);
                                                if (!empty($reason)) {
                                                    foreach ($reason as $reasons) {
                                                        echo htmlspecialchars($reasons) . ", ";
                                                    }
                                                } ?>
                                            </p>
                                        </div>
                                        <div class="col-md-6" id="view-app-calendar">
                                            <?php include './img/calendar.svg'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- findings -->
                        <?php
                        if (!empty($all_findings)) {
                            foreach ($all_findings as $finding) {
                                $c_id = $finding['child_id'];
                                $stmt = $pdo->prepare("SELECT * FROM child_tbl WHERE child_id = $c_id");
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                $child_n = $result['c_fname'] . ' ' . $result['c_m_name'] . ' ' . $result['c_lname'];
                                ?>
                                <div class="col-md-12 mb-4">
                                    <div class="card shadow">
                                        <div class="card-header">
                                            <h6 class="m-0 font-weight-bold text-secondary">Check-up Findings</h6>
                                        </div>

                                        <div class="card-body text-center">
                                            <div class="row px-4 d-flex align-items-center">
                                                <div class="col-md-12">
                                                    <p class="text-center"><?php echo $child_n; ?></p>
                                                </div>
                                                <div class="col-md-3">
                                                    <p class="text-gray small mb-1 mt-3">Weight</p>
                                                    <input type="text" class="form-control bg-light text-muted text-center"
                                                        style="font-size: 13px;" value="<?php echo $finding['weight']; ?>"
                                                        disabled>
                                                </div>

                                                <div class="col-md-3">
                                                    <p class="text-gray small mb-1 mt-3">Height</p>
                                                    <input type="text" class="form-control bg-light text-muted text-center"
                                                        style="font-size: 13px;" value="<?php echo $finding['height']; ?>"
                                                        disabled>
                                                </div>

                                                <div class="col-md-3">
                                                    <p class="text-gray small mb-1 mt-3">Head circumference</p>
                                                    <input type="text" class="form-control bg-light text-muted text-center"
                                                        style="font-size: 13px;"
                                                        value="<?php echo $finding['head_circumference']; ?>" disabled>
                                                </div>

                                                <div class="col-md-3">
                                                    <p class="text-gray small mb-1 mt-3">Chest circumference</p>
                                                    <input type="text" class="form-control bg-light text-muted text-center"
                                                        style="font-size: 13px;"
                                                        value="<?php echo $finding['chest_circumference']; ?>" disabled>
                                                </div>

                                                <div class="col-md-4">
                                                    <p class="text-gray small mb-1 mt-3">Developmental milestones</p>
                                                    <input type="text" class="form-control bg-light text-muted text-center"
                                                        style="font-size: 13px;"
                                                        value="<?php echo $finding['developmental_milestones']; ?>" disabled>
                                                </div>

                                                <div class="col-md-4">
                                                    <p class="text-gray small mb-1 mt-3">Physical exam</p>
                                                    <input type="text" class="form-control bg-light text-muted text-center"
                                                        style="font-size: 13px;"
                                                        value="<?php echo $finding['physical_exam']; ?>" disabled>
                                                </div>

                                                <div class="col-md-4">
                                                    <p class="text-gray small mb-1 mt-3">Immunization status</p>
                                                    <input type="text" class="form-control bg-light text-muted text-center"
                                                        style="font-size: 13px;"
                                                        value="<?php echo $finding['immunization_status']; ?>" disabled>
                                                </div>

                                                <div class="col-md-4">
                                                    <p class="text-gray small mb-1 mt-3">Medical history</p>
                                                    <input type="text" class="form-control bg-light text-muted text-center"
                                                        style="font-size: 13px;"
                                                        value="<?php echo $finding['medical_history']; ?>" disabled>
                                                </div>

                                                <div class="col-md-8">
                                                    <p class="text-gray small mb-1 mt-3">Assessment recommendations</p>
                                                    <input type="text" class="form-control bg-light text-muted text-center"
                                                        style="font-size: 13px;"
                                                        value="<?php echo $finding['assessment_recommendations']; ?>" disabled>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }
                        ?>

                        <!-- vaccine -->
                        <?php
                        if (!empty($all_immunization)) {
                            foreach ($all_immunization as $immunization) {
                                $c_id = $immunization['child_id'];
                                $stmt = $pdo->prepare("SELECT * FROM child_tbl WHERE child_id = $c_id");
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                $child_n = $result['c_fname'] . ' ' . $result['c_m_name'] . ' ' . $result['c_lname'];
                                ?>
                                <div class="col-md-12 mb-4">
                                    <div class="card shadow">
                                        <div class="card-header">
                                            <h6 class="m-0 font-weight-bold text-secondary">Immunization</h6>
                                        </div>

                                        <div class="card-body text-center">
                                            <div class="row px-4 d-flex align-items-center">
                                                <div class="col-md-12">
                                                    <p class="text-center"><?php echo $child_n; ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="text-gray small mb-1 mt-3">Vaccine</p>
                                                    <input type="text" class="form-control bg-light text-muted text-center"
                                                        style="font-size: 13px;" value="<?php echo $immunization['vaccine']; ?>"
                                                        disabled>
                                                </div>

                                                <div class="col-md-4">
                                                    <p class="text-gray small mb-1 mt-3">Dose</p>
                                                    <input type="text" class="form-control bg-light text-muted text-center"
                                                        style="font-size: 13px;" value="<?php echo $immunization['dose']; ?>"
                                                        disabled>
                                                </div>

                                                <div class="col-md-4">
                                                    <p class="text-gray small mb-1 mt-3">Pediatrician</p>
                                                    <input type="text" class="form-control bg-light text-muted text-center"
                                                        style="font-size: 13px;"
                                                        value="<?php echo $immunization['pediatrician']; ?>" disabled>
                                                </div>

                                                <div class="col-md-4">
                                                    <p class="text-gray small mb-1 mt-3">Reaction</p>
                                                    <input type="text" class="form-control bg-light text-muted text-center"
                                                        style="font-size: 13px;"
                                                        value="<?php echo $immunization['reaction']; ?>" disabled>
                                                </div>

                                                <?php if ($immunization['record_type'] == 'new') { ?>
                                                    <div class="col-md-4">
                                                        <p class="text-gray small mb-1 mt-3">Next vaccine</p>
                                                        <input type="text" class="form-control bg-light text-muted text-center"
                                                            style="font-size: 13px;"
                                                            value="<?php echo $immunization['next_vaccine']; ?>" disabled>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <p class="text-gray small mb-1 mt-3">Next appointment</p>
                                                        <input type="text" class="form-control bg-light text-muted text-center"
                                                            style="font-size: 13px;" value="<?php
                                                            $next_app = date("l, F j, Y", strtotime($immunization['next_appointment']));
                                                            echo $next_app;
                                                            ?>" disabled>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }
                        ?>

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