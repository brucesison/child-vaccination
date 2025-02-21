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
    $unique_id = $parent_info['unique_id'];
    
    $u_m_name = $parent_info['u_m_name'];

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

    // get the status of the submitted form (success/error)
    $status = $_GET['status'] ?? '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>My Profile</title>
    <link rel="icon" href="../includes/icon/favicon.ico">
    <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

    <!-- check if form is submitted successfully -->
    <?php if ($status == 'details_updated'): ?>
        <script>
            Swal.fire({
                title: "Success",
                text: "Details updated!",
                icon: "success",
                confirmButtonColor: "#009c95"
            });
        </script>
    <?php elseif ($status == 'image_updated'): ?>
        <script>
            Swal.fire({
                title: "Success",
                text: "Profile picture updated!",
                icon: "success",
                confirmButtonColor: "#009c95"
            });
        </script>
    <?php elseif ($status == 'pass_updated'): ?>
        <script>
            Swal.fire({
                title: "Success",
                text: "Password updated!",
                icon: "success",
                confirmButtonColor: "#009c95"
            });
        </script>
    <!-- else this page will load with page loader haha nice -->
    <?php else: include './includes/page_loader.php'; ?>
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
                    <div class="mb-4">
                        <h1 class="h3 mb-0 text-gray-800">My Profile</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row my-5 d-flex h-100">
                        <div class="col-md-4 mb-4">
                            <div class="card shadow">
                                <div class="card-header">Profile Picture</div>

                                <!-- change photo modal -->
                                <?php include 'modals/change_photo_modal.php'; ?>

                                <!-- view parent photo modal -->
                                <?php include 'modals/view_my_profile_modal.php'; ?>

                                <div class="card-body text-center">
                                    <div class="mt-3 mb-1">
                                        <!-- image profile -->
                                        <img src="<?php echo htmlspecialchars($parent_info['profile_image']); ?>"
                                            class="rounded-circle img-fluid border p-2 parent-pic"
                                            style="width: 100px; height: 100px" data-toggle="modal"
                                            data-target="#view_my_pic" />
                                    </div>
                                    <p class="text-xs text-main change-photo font-weight-bold mb-3" data-toggle="modal"
                                        data-target="#change_my_photo">Change Photo</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card shadow">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 text-secondary">Account Details</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Action:</div>
                                            <button class="dropdown-item" data-toggle="modal"
                                                data-target="#edit_my_profile">Edit</button>
                                            <button class="dropdown-item" data-toggle="modal"
                                                data-target="#edit_pass">Security</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- edit parent details modal -->
                                <?php include 'modals/edit_my_details_modal.php'; ?>

                                <!-- edit parent pass modal -->
                                <?php include 'modals/edit_my_pass_modal.php'; ?>

                                <div class="card-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="text-gray small mb-1 mt-3">Name</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php echo $parent_info['u_fname'] . ' ' . $initials . ' ' . $parent_info['u_lname']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-gray small mb-1 mt-3">Email</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php echo $parent_info['email']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-gray small mb-1 mt-3">Contact No.</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;"
                                                    value="0<?php echo $parent_info['contact_no']; ?>" disabled>
                                            </div>
                                        </div>

                                        <p class="text-secondary mt-5">Address:</p>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="text-gray small mb-1 mt-3">Barangay</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;"
                                                    value="<?php echo $parent_info['barangay']; ?>" disabled>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-gray small mb-1 mt-3">Street</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;"
                                                    value="<?php echo $parent_info['street']; ?>" disabled>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-gray small mb-1 mt-3">City</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php echo $parent_info['city']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-gray small mb-1 mt-3">State</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;" value="<?php echo $parent_info['state']; ?>"
                                                    disabled>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-gray small mb-1 mt-3">Zipcode</p>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    style="font-size: 13px;"
                                                    value="<?php echo $parent_info['zipcode']; ?>" disabled>
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