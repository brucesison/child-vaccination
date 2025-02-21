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

  $vaccine = $functions->getAllVaccine();

  // get the status of the submitted form (success/error)
  $status = $_GET['status'] ?? '';

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $active_vaccine_list = '';
  if ($current_page == 'list_vaccine.php') {
    $active_vaccine_list = 'active';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Vaccines</title>
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
  <?php elseif ($status == 'updated'): ?>
    <script>
      Swal.fire({
        title: "",
        text: "Vaccine updated",
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
            <h1 class="h3 mb-0 text-gray-800">Vaccines</h1>
          </div>

          <!-- Content Row -->
          <div class="row my-5 d-flex align-items-center h-100">

            <div class="col-md-12 mb-5">
              <button class="btn btn-sm btn-main shadow-sm" data-toggle="modal" data-target="#add_vaccine">
                <i class="fas fa-plus fa-sm text-light"></i> Add vaccine
              </button>
            </div>

            <?php include 'modals/add_vaccine_modal.php'; ?>


            <div class="col-md-12">
              <div class="card shadow">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <td>#</td>
                          <td>Vaccine name</td>
                          <td>Quantity</td>
                          <td>Status</td>
                          <td>Action</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $count = 1; ?>
                        <?php foreach ($vaccine as $row) {
                          ?>
                          <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo $row['vaccine_name']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php
                            if ($row['quantity'] < 1) {
                              echo 'Not Available';
                            } else {
                              echo 'Available';
                            }
                            ?></td>
                            <td class="text-center">
                              <button data-toggle="modal" data-target="#view_vaccine_<?php echo $row['vaccine_id']; ?>"
                                class="btn btn-sm btn-main"><i class="fas fa-fw fa-eye mr-1"></i>View</button>
                              <button data-toggle="modal" data-target="#edit_vaccine_<?php echo $row['vaccine_id']; ?>"
                                class="btn btn-sm btn-info"><i class="fas fa-fw fa-edit mr-1"></i>Edit</button>
                              <button data-toggle="modal" data-target="#delete_vaccine_<?php echo $row['vaccine_id']; ?>"
                                class="btn btn-sm btn-danger"><i class="fas fa-fw fa-trash mr-1"></i>Delete</button>
                            </td>
                            <?php include 'modals/view_vaccine_modal.php'; ?>
                            <?php include 'modals/edit_vaccine_modal.php'; ?>
                            <?php include 'modals/delete_vaccine_modal.php'; ?>
                          </tr>
                          <?php $count++; ?>
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

  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable({
        dom: 'lBfrtip',  // Places the buttons
        buttons: [
          {
            extend: 'excelHtml5',
            text: 'Export to Excel',
            exportOptions: {
              columns: ':visible:not(:last-child), :hidden'  // Include hidden columns but exclude columns with class "no-export"
            },
            title: 'Data Export',
            filename: 'Vaccine List'
          },
          {
            extend: 'pdfHtml5',
            text: 'Export to PDF',
            exportOptions: {
              columns: ':visible:not(:last-child), :hidden'  // Include hidden columns but exclude columns with class "no-export"
            },
            title: 'Data Export',
            filename: 'Vaccine List',
            orientation: 'landscape',  // PDF layout (portrait or landscape)
            pageSize: 'A4',  // PDF page size (A4, A5, etc.)
          },
          {
            extend: 'print',
            text: 'Print',
            exportOptions: {
              columns: ':visible:not(:last-child)'  // Include hidden columns but exclude columns with class "no-export"
            },
            title: 'Vaccine List'
          }
        ]
      });
    });
  </script>

</body>

</html>