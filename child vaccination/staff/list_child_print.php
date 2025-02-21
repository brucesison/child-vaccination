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

  $parents = $functions->getAllParents();
  $child = $functions->getAllChild();

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $active_child_list = '';
  if ($current_page == 'list_child_table.php') {
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
  <title>Child List</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

  <!-- check if form is submitted successfully -->
  <?php if ($status == 'added_successfully'): ?>
    <script>
      Swal.fire({
        title: "Success",
        text: "Child added successfully.",
        icon: "success",
        confirmButtonColor: "#009c95"
      });
    </script>
    <!-- check if doctor is deleted successfully -->
  <?php elseif ($status == 'deleted_successfully'): ?>
    <script>
      Swal.fire({
        title: "Success",
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
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 nonprint">Print Layout</h1>
          </div>

          <button class="btn btn-sm btn-main shadow-sm mt-3" id="btnprint" onclick="printPage()">
            <i class="fas fa-print fa-sm text-light"></i> Print
          </button>

          <!-- add parent modal-->
          <?php include './modals/add_child_modal.php'; ?>

          <!-- Content Row -->
          <div class="row my-5 d-flex align-items-center h-100">
            <div class="col-md-12">
              <div class="card shadow">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <td>Name</td>
                          <td>Immunization Status</td>
                          <td>Mother Name</td>
                          <td>Father Name</td>
                          <td>Guardian Name</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($child as $row) { ?>
                          <tr>
                            <td><?php echo $row['child_name']; ?></td>

                            <!-- calculate if the child completed the immunization -->
                            <td class="font-weight-bold">
                              <?php
                              $child_id = $row['child_id'];
                              $imm_stat = $functions->getImmunizationCount($child_id);
                              foreach ($imm_stat as $count2) {
                                foreach ($count2 as $key2 => $val2)
                                  if ($val2 == 15) {
                                    echo "Completed";
                                  } else {
                                    echo "Not Complete";
                                  }
                              }
                              ?>
                            </td>

                            <td><?php echo $row['mother_name']; ?></td>
                            <td><?php echo $row['father_name']; ?></td>
                            <td><?php echo $row['guardian_name']; ?></td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
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

  <script src="./js/print.js"></script>

</body>

</html>