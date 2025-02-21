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

    if (isset($_GET['user_id'])) {
        $parent = $functions->getThisParent($_GET['user_id']);
        $parent_id = $parent['user_id'];

        $u_m_name = $parent['u_m_name'];

        // Split the name into words
        $words = explode(' ', $u_m_name);

        // Get the first letter of each word and concatenate with a period
        if (count($words) > 1) {
            // For two words, get the first letter of each
            $initials = strtoupper(substr($words[0], 0, 1)) . strtoupper(substr($words[1], 0, 1)) . '.';
        } else {
            // For one word, get only the first letter
            $initials = strtoupper(substr($u_m_name, 0, 1)) . '.';
        }

        $stmt = $pdo->prepare("SELECT status FROM user_tbl WHERE user_id = $parent_id");
        $stmt->execute();
        $status = $stmt->fetch(PDO::FETCH_ASSOC);
        $account_status = $status['status'];

        $stmt = $pdo->prepare("SELECT * FROM child_tbl WHERE parent_id = $parent_id");
        $stmt->execute();
        $child = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Pagination logic
        // Get the current page from the URL, default to 1 if not present
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        // Get paginated appointment history
        $result = $functions->getPaginatedAppointmentHistory($pdo, $parent_id, $page);
        $history = $result['history'];
        $total_pages = $result['total_pages'];

        $not_verified_content = 'd-none';
        $verified_content = 'd-flex';
        if ($account_status == 'not-verified') {
            $verified_content = 'd-none';
            $not_verified_content = 'd-flex';
        }


        $no_child_svg = 'd-none';
        $no_child_text = 'd-none';
        if (empty($child)) {
            $no_child_svg = 'd-flex';
            $no_child_text = 'd-block';
        }

    }

    // get the status of the submitted form (success/error)
    $acc_status = $_GET['acc_status'] ?? '';
    $status = $_GET['status'] ?? '';

    // Get the current script name
    $current_page = basename($_SERVER['PHP_SELF']);
    $active_parent_list = '';
    if ($current_page == 'view_parent.php') {
        $active_parent_list = 'active';
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $parent['u_fname'] . ' ' . $initials . ' ' . $parent['u_lname'] . "'s Profile"; ?>
    </title>
    <link rel="icon" href="../includes/icon/favicon.ico">
    <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

    <!-- check if form is submitted successfully -->
    <?php if ($acc_status == 'verified'): ?>
        <script>
            Swal.fire({
                title: "",
                text: "Account verified!.",
                icon: "success",
                confirmButtonColor: "#009c95"
            });
        </script>
    <?php elseif ($status == 'details_updated'): ?>
        <script>
            Swal.fire({
                title: "",
                text: "Details updated!",
                icon: "success",
                confirmButtonColor: "#009c95"
            });
        </script>
        <!-- check if image is updated -->
    <?php elseif ($status == 'profile_updated'): ?>
        <script>
            Swal.fire({
                title: "",
                text: "Image updated!",
                icon: "success",
                confirmButtonColor: "#009c95"
            });
        </script>
    <?php elseif ($status == 'password_updated'): ?>
        <script>
            Swal.fire({
                title: "",
                text: "Password updated!",
                icon: "success",
                confirmButtonColor: "#009c95"
            });
        </script>
        <!-- else this page will load with page loader haha nice -->
    <?php else:
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

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-light small shadow">
                            <li class="breadcrumb-item"><a class="text-main"
                                    href="list_parent_table.php">Parent/Guardian
                                    list</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View parent/guardian</li>
                        </ol>
                    </nav>

                    <!-- Content Row for not verified account -->
                    <?php include './includes/if_not_verified.php'; ?>

                    <!-- Content Row -->
                    <div class="row my-5 h-100 <?php echo $verified_content; ?>">
                        <div class="col-md-4 mb-4">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="card shadow">
                                        <div class="card-header">
                                            <div class="float-right dropdown no-arrow">
                                                <a class="dropdown-toggle" role="button" id="dropdownMenuLink"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                    aria-labelledby="dropdownMenuLink">
                                                    <div class="dropdown-header">Action:</div>
                                                    <button class="dropdown-item" data-toggle="modal"
                                                        data-target="#edit_parent">Edit</button>
                                                    <button class="dropdown-item" data-toggle="modal"
                                                        data-target="#edit_security">Security</button>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item-delete <?php echo $admin_access; ?>"
                                                        data-toggle="modal" data-target="#delete_parent">Delete</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- change photo modal -->
                                        <?php include 'modals/change_photo_modal.php'; ?>

                                        <!-- edit parent modal -->
                                        <?php include 'modals/edit_parent_modal.php'; ?>

                                        <!-- edit parent security modal -->
                                        <?php include 'modals/edit_parent_security_modal.php'; ?>

                                        <!-- delete parent modal -->
                                        <?php include 'modals/delete_parent_modal.php'; ?>

                                        <!-- view parent profile modal -->
                                        <?php include 'modals/view_profile_modal.php'; ?>

                                        <div class="card-body text-center">
                                            <div class="mt-3 mb-1">
                                                <!-- image profile -->
                                                <img src="<?php echo htmlspecialchars($parent['profile_image']); ?>"
                                                    class="rounded-circle img-fluid border p-2 parent-pic"
                                                    style="width: 100px; height: 100px" data-toggle="modal"
                                                    data-target="#view_parent_pic" />
                                            </div>
                                            <p class="text-xs text-main change-photo font-weight-bold mb-3"
                                                data-toggle="modal" data-target="#change_photo">Change Photo</p>
                                            <h5 class="mb-2 text-dark">
                                                <?php echo $parent['u_fname'] . ' ' . $initials . ' ' . $parent['u_lname']; ?>
                                            </h5>
                                            <p class="text-dark mb-2 small">
                                                ( <?php echo $parent['relationship']; ?> )
                                            </p>
                                            <p class="text-main mb-2 small"><?php echo $parent['email']; ?></p>
                                            <p class="text-secondary mb-4 small">0<?php echo $parent['contact_no']; ?>
                                            </p>
                                            <hr class="sidebar-divider">
                                            <p class="text-secondary mb-2">Address</p>
                                            <p class="text-secondary small mb-3">
                                                <?php echo $parent['street'] . ', ' . $parent['barangay'] . ', ' . $parent['city'] . ', ' . $parent['state'] . ', ' . $parent['zipcode']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="card shadow">
                                        <div class="card-header text-center">Registered Child</div>
                                        <div class="card-body">
                                            <?php
                                            foreach ($child as $row) {
                                                $c_m_name = $row['c_m_name'];

                                                // Split the name into words
                                                $words1 = explode(' ', $c_m_name);

                                                // Get the first letter of each word and concatenate with a period
                                                if (count($words1) > 1) {
                                                    // For two words, get the first letter of each
                                                    $initials1 = strtoupper(substr($words1[0], 0, 1)) . strtoupper(substr($words1[1], 0, 1)) . '.';
                                                } else {
                                                    // For one word, get only the first letter
                                                    $initials1 = strtoupper(substr($c_m_name, 0, 1)) . '.';
                                                }
                                                ?>
                                                <div class="col-md-12 mb-3 d-flex align-items-center bg-light p-3 rounded">
                                                    <img src="<?php echo htmlspecialchars($row['child_pic']); ?>"
                                                        alt="child profile" class="child-profile rounded-circle mr-3">
                                                    <div class="text-secondary">
                                                        <a href="view_child.php?child_id=<?php echo $row['child_id']; ?>"
                                                            class="text-dark">
                                                            <?php echo $row['c_fname'] . ' ' . $initials1 . ' ' . $row['c_lname']; ?>
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="col-md-12 <?php echo $no_child_svg; ?>">
                                                <?php include 'img/no_data.svg'; ?>
                                            </div>
                                            <div class="col-md-12 <?php echo $no_child_text; ?>">
                                                <h5 class="text-center small">No registered child yet.</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card shadow">
                                <div class="card-header text-main text-center">Appointment History</div>
                                <div class="card-body">
                                    <?php if (!empty($history)) { ?>
                                        <div
                                            class="table table-responsive table-striped align-items-center justify-content-center small">
                                            <table class="mx-auto">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Child's Name</th>
                                                        <th>Reason for visit</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($history as $row) {
                                                        ?>
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
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pagination Controls -->
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item <?php if ($page <= 1) {
                                                    echo 'disabled';
                                                } ?>">
                                                    <a class="page-link"
                                                        href="<?php echo '?user_id=' . $parent_id . '&page=' . ($page - 1); ?>"
                                                        aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                                    <li class="page-item <?php if ($i == $page) {
                                                        echo 'active';
                                                    } ?>">
                                                        <a class="page-link"
                                                            href="<?php echo '?user_id=' . $parent_id . '&page=' . $i; ?>"><?php echo $i; ?></a>
                                                    </li>
                                                <?php } ?>
                                                <li class="page-item <?php if ($page >= $total_pages) {
                                                    echo 'disabled';
                                                } ?>">
                                                    <a class="page-link"
                                                        href="<?php echo '?user_id=' . $parent_id . '&page=' . ($page + 1); ?>"
                                                        aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>

                                    <?php } else { ?>
                                        <div class="col-md-12">
                                            <div class="row align-items-center justify-content-center">
                                                <div class="col-md-7">
                                                    <?php include 'img/no_data.svg'; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <h5 class="text-center small">No appointment history found.</h5>
                                        </div>
                                    <?php } ?>
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