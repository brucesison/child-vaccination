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

    if (isset($_GET['child_id'])) {
        $child = $functions->getThisChild($_GET['child_id']);
        // Assuming $c_m_name holds the value like "Dela Cruz" or "Sison"
        $c_m_name = $child['c_m_name'];
        $m_m_name = $child['m_m_name'];
        $f_m_name = $child['f_m_name'];
        $g_m_name = $child['g_m_name'];

        // Split the name into words
        $words = explode(' ', $c_m_name);
        $words1 = explode(' ', $m_m_name);
        $words2 = explode(' ', $f_m_name);
        $words3 = explode(' ', $g_m_name);

        // Get the first letter of each word and concatenate with a period
        if (count($words) > 1 || count($words1) > 1 || count($words2) > 1 || count($words3) > 1) {
            // For two words, get the first letter of each
            $initials = strtoupper(substr($words[0], 0, 1)) . strtoupper(substr($words[1], 0, 1)) . '.';
            $initials1 = strtoupper(substr($words1[0], 0, 1)) . strtoupper(substr($words1[1], 0, 1)) . '.';
            $initials2 = strtoupper(substr($words2[0], 0, 1)) . strtoupper(substr($words2[1], 0, 1)) . '.';
            $initials3 = strtoupper(substr($words3[0], 0, 1)) . strtoupper(substr($words3[1], 0, 1)) . '.';
        } else {
            // For one word, get only the first letter
            $initials = strtoupper(substr($c_m_name, 0, 1)) . '.';
            $initials1 = strtoupper(substr($m_m_name, 0, 1)) . '.';
            $initials2 = strtoupper(substr($f_m_name, 0, 1)) . '.';
            $initials3 = strtoupper(substr($g_m_name, 0, 1)) . '.';
        }
    }

    // get the status of the submitted form (success/error)
    $status = $_GET['status'] ?? '';

    // Get the current script name
    $current_page = basename($_SERVER['PHP_SELF']);
    $active_child_list = '';
    if ($current_page == 'view_child.php') {
        $active_child_list = 'active';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $child['c_fname'] . ' ' . $initials . ' ' . $child['c_lname']; ?>'s Profile</title>
    <link rel="icon" href="../includes/icon/favicon.ico">
    <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

    <!-- check if form is submitted successfully -->
    <?php if ($status == 'child_updated'): ?>
        <script>
            Swal.fire({
                title: "",
                text: "Details updated!",
                icon: "success",
                confirmButtonColor: "#009c95"
            });
        </script>
        <!-- check if image is updated -->
    <?php elseif ($status == 'image_updated'): ?>
        <script>
            Swal.fire({
                title: "",
                text: "Image updated!",
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

                    <!-- <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-light small shadow">
                            <li class="breadcrumb-item"><a class="text-main" href="my_child.php">My Child</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Child</li>
                        </ol>
                    </nav> -->

                    <nav class="nav">
                        <a href="view_child.php?child_id=<?php echo $child['child_id']; ?>"
                            class="nav-link text-light bg-main rounded small">Profile</a>
                        <a href="child_immunization.php?child_id=<?php echo $child['child_id']; ?>"
                            class="nav-link text-secondary small">Immunization</a>
                        <a href="child_findings.php?child_id=<?php echo $child['child_id']; ?>"
                            class="nav-link text-secondary small">Findings</a>
                    </nav>

                    <!-- Content Row -->
                    <div class="row my-5 h-100">
                        <div class="col-md-3 mb-4">
                            <div class="card shadow">
                                <div class="card-header">Profile Picture</div>

                                <!-- change photo modal -->

                                <!-- view parent photo modal -->

                                <div class="card-body text-center">
                                    <div class="mt-3 mb-1">
                                        <!-- image profile -->
                                        <img src="<?php echo htmlspecialchars($child['child_pic']); ?>"
                                            class="rounded-circle img-fluid border p-2 parent-pic"
                                            style="width: 100px; height: 100px" data-toggle="modal"
                                            data-target="#view_child_pic" />
                                    </div>
                                    <p class="text-xs text-main change-photo font-weight-bold mb-3" data-toggle="modal"
                                        data-target="#change_child_photo">Change Photo</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="card shadow">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 text-secondary">Child Info</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Action:</div>
                                            <button class="dropdown-item" data-toggle="modal"
                                                data-target="#edit_child">Edit</button>
                                            <button class="dropdown-item-delete <?php echo $admin_access; ?>"
                                                data-toggle="modal" data-target="#delete_child">Delete</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- edit child details modal -->
                                <?php include 'modals/edit_child_modal.php'; ?>

                                <!-- view child photo modal -->
                                <?php include 'modals/view_child_pic_modal.php'; ?>

                                <!-- edit child photo modal -->
                                <?php include 'modals/change_child_photo_modal.php'; ?>

                                <!-- edit child photo modal -->
                                <?php include 'modals/delete_child_modal.php'; ?>

                                <div class="card-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p class="text-gray small mb-1 mt-3">Child name</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;"
                                                    value="<?php echo $child['c_fname'] . ' ' . $initials . ' ' . $child['c_lname']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="text-gray small mb-1 mt-3">Date of birth</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php
                                                    // Format the date to include the name of the month
                                                    $f_date = date("F j, Y", strtotime($child['birth_date']));
                                                    echo $f_date; ?>" disabled>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="text-gray small mb-1 mt-3">Time of birth</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php
                                                    // Convert the time to 12-hour format with AM/PM
                                                    $formatted_time = date('h:i A', strtotime($child['birth_time']));
                                                    echo $formatted_time;
                                                    ?>" disabled>
                                            </div>

                                            <div class="col-md-2">
                                                <?php
                                                $dob = $child['birth_date'];
                                                $dobDateTime = new DateTime($dob);
                                                $currentDateTime = new DateTime();
                                                $interval = $dobDateTime->diff($currentDateTime);

                                                // Determine if the age is in years or weeks
                                                if ($interval->y >= 1) {
                                                    // Display age in years
                                                    $age = $interval->y;
                                                    $label = "Age";
                                                } else {
                                                    // Display age in weeks
                                                    $age = floor($interval->days / 7);
                                                    $label = "Age in weeks";
                                                }
                                                ?>

                                                <p class="text-gray small mb-1 mt-3"><?php echo $label; ?></p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php echo $age; ?>" disabled>
                                            </div>

                                            <div class="col-md-2">
                                                <p class="text-gray small mb-1 mt-3">Gender</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php echo $child['gender']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Mother name</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;"
                                                    value="<?php echo $child['m_fname'] . ' ' . $initials1 . ' ' . $child['m_lname']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Father name</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;"
                                                    value="<?php echo $child['f_fname'] . ' ' . $initials2 . ' ' . $child['f_lname']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Guardian name</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;"
                                                    value="<?php echo $child['g_fname'] . ' ' . $initials3 . ' ' . $child['g_lname']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Mother contact no.</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;"
                                                    value="0<?php echo $child['mother_contact']; ?>" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Father contact no.</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;"
                                                    value="0<?php echo $child['father_contact']; ?>" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Guardian contact no.</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;"
                                                    value="0<?php echo $child['guardian_contact']; ?>" disabled>
                                            </div>
                                        </div>

                                        <p class="text-secondary mt-5">Birth Info:</p>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Place of birth</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php echo $child['hospital']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Obstretician</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;"
                                                    value="<?php echo $child['obstretician']; ?>" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Pediatrician</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;"
                                                    value="<?php echo $child['pediatrician']; ?>" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Type of delivery</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;"
                                                    value="<?php echo $child['type_of_delivery']; ?>" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Weight (kg)</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php echo $child['weight']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Height (cm)</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php echo $child['height']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Head circumference (cm)</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php echo $child['head']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Chest circumference (cm)</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php echo $child['chest']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">APGR Score (cm)</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php echo $child['apgar']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Blood type</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php echo $child['blood_type']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Eye color</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php echo $child['eye_color']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-gray small mb-1 mt-3">Hair color</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php echo $child['hair_color']; ?>"
                                                    disabled>
                                            </div>
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

    <!-- file input -->
    <script>
        // Get references to the elements
        const fileInput = document.getElementById('file-input');
        const uploadButton = document.getElementById('upload-button');
        const fileNameSpan = document.getElementById('file-name');
        var uploadBtn = document.getElementById('upload-btn');

        // Add event listener to the button
        uploadButton.addEventListener('click', function () {
            fileInput.click();
        });

        // Add event listener to the file input
        fileInput.addEventListener('change', function () {
            if (fileInput.files.length > 0) {
                fileNameSpan.textContent = fileInput.files[0].name;
                uploadBtn.disabled = false;
            } else {
                fileNameSpan.textContent = 'No file chosen';
                uploadBtn.disabled = true;
            }
        });
    </script>

</body>

</html>