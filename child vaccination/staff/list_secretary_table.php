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

  $secretary = $functions->getAllSecretary();

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $active_secretary_list = '';
  if ($current_page == 'list_secretary_table.php') {
    $active_secretary_list = 'active';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Secretary List</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

  <!-- check if form is submitted successfully -->
  <?php if ($status == 'added_successfully'): ?>
    <script>
      Swal.fire({
        title: "",
        text: "Secretary added!",
        icon: "success",
        confirmButtonColor: "#009c95"
      });
    </script>
    <!-- check if secretary is deleted successfully -->
  <?php elseif ($status == 'deleted_successfully'): ?>
    <script>
      Swal.fire({
        title: "",
        text: "Deleted!",
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
            <h1 class="h3 mb-0 text-gray-800">Secretary List</h1>
          </div>

          <button type="button" class="btn btn-sm btn-main d-flex align-items-center" data-toggle="modal"
            data-target="#add_secretary">
            <i class="fas fa-fw fa-plus mr-1"></i>Add Secretary
          </button>

          <!-- <a href="list_child_print.php" class="btn btn-sm btn-main shadow-sm mt-3">
            <i class="fas fa-print fa-sm text-light"></i> Print
          </a> -->

          <!-- add parent modal-->
          <?php include './modals/add_secretary_modal.php'; ?>

          <!-- Content Row -->
          <div class="row my-5 d-flex align-items-center h-100">
            <div class="col-md-12">
              <div class="card shadow">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <td>#</td>
                          <td>Name</td>
                          <td>Email</td>
                          <td>Contact No.</td>
                          <td class="d-none">Barangay</tdc>
                          <td class="d-none">Street</tdc>
                          <td class="d-none">City</tdc>
                          <td class="d-none">State</tdc>
                          <td class="d-none">Zipcode</tdc>
                          <td>Action</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $count = 1; ?>
                        <?php foreach ($secretary as $row) {
                          $s_m_name = $row['s_m_initial'];

                          // Split the name into words
                          $words1 = explode(' ', $s_m_name);

                          // Get the first letter of each word and concatenate with a period
                          if (count($words1) > 1) {
                            // For two words, get the first letter of each
                            $initials1 = strtoupper(substr($words1[0], 0, 1)) . strtoupper(substr($words1[1], 0, 1)) . '.';
                          } else {
                            // For one word, get only the first letter
                            $initials1 = strtoupper(substr($s_m_name, 0, 1)) . '.';
                          }
                          ?>
                          <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo $row['s_fname'] . ' ' . $initials1 . ' ' . $row['s_lname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>0<?php echo $row['contact_no']; ?></td>
                            <td class="d-none"><?php echo $row['barangay']; ?></td>
                            <td class="d-none"><?php echo $row['street']; ?></td>
                            <td class="d-none"><?php echo $row['city']; ?></td>
                            <td class="d-none"><?php echo $row['state']; ?></td>
                            <td class="d-none"><?php echo $row['zipcode']; ?></td>
                            <td><a href="view_secretary.php?staff_id=<?php echo $row['staff_id']; ?>"
                                class="btn btn-sm btn-main"><i class="fas fa-fw fa-eye mr-1"></i>View</a>
                            </td>
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
            filename: 'Secretary List'
          },
          {
            extend: 'pdfHtml5',
            text: 'Export to PDF',
            exportOptions: {
              columns: ':visible:not(:last-child), :hidden'  // Include hidden columns but exclude columns with class "no-export"
            },
            title: 'Data Export',
            filename: 'Secretary List',
            orientation: 'landscape',  // PDF layout (portrait or landscape)
            pageSize: 'A4',  // PDF page size (A4, A5, etc.)
          },
          {
            extend: 'print',
            text: 'Print',
            exportOptions: {
              columns: ':visible:not(:last-child)'  // Include hidden columns but exclude columns with class "no-export"
            },
            title: 'Secretary List'
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