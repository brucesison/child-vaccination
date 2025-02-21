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

  $breaks = $functions->getAllBreak();

  // get the status of the submitted form (success/error)
  $status = $_GET['status'] ?? '';

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $active_appointment = '';

  if ($current_page == 'app_break.php') {

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
  <title>Appointment Break</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

  <!-- check if form is submitted successfully -->
  <?php if ($status == 'added_successfully'): ?>
    <script>
      Swal.fire({
        title: "",
        text: "Added successfully.",
        icon: "success",
        confirmButtonColor: "#009c95"
      });
    </script>
    <!-- check if doctor is deleted successfully -->
  <?php elseif ($status == 'deleted_successfully'): ?>
    <script>
      Swal.fire({
        title: "",
        text: "Deleted successfully.",
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
          <div class="mb-4">
            <h1 class="h3 mb-0 text-gray-800">Appointment Break</h1>
          </div>

          <!-- Content Row -->
          <div class="row my-5">

            <!-- add break -->
            <div class="col-md-12 mb-5">
              <button class="btn btn-sm btn-main shadow-sm" data-toggle="modal" data-target="#add_break">
                <i class="fas fa-plus fa-sm text-light"></i> Add break
              </button>
            </div>

            <?php include 'modals/add_break_modal.php'; ?>

            <?php if (!empty($breaks)) { ?>
              <?php foreach ($breaks as $row) { ?>
                <div class="col-md-3 mb-3">
                  <div class="card shadow-sm mb-3">
                    <div class="card-header">
                      <div class="float-right dropdown no-arrow">
                        <a class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                          aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                          aria-labelledby="dropdownMenuLink">
                          <div class="dropdown-header">Action:</div>
                          <button class="dropdown-item" data-toggle="modal"
                            data-target="#edit_break_<?php echo $row['break_id']; ?>">Edit</button>
                          <div class="dropdown-divider"></div>
                          <button class="dropdown-item-delete" data-toggle="modal"
                            data-target="#delete_break_<?php echo $row['break_id']; ?>">Delete</button>
                        </div>
                      </div>
                    </div>
                    <div class="card-body text-center">
                      <h5 class="text-dark mb-4"><?php
                      $f_date = date("F j, Y", strtotime($row['break_date']));
                      echo $f_date; ?></h5>
                      <p class="font-weight-bold text-secondary mb-0">Reason:</p>
                      <p class="small"><?php echo $row['reason']; ?></p>
                      <?php include 'modals/edit_break_modal.php'; ?>
                      <?php include 'modals/delete_break_modal.php'; ?>
                    </div>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>
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