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

  $doctors = $functions->getAllDoctor();

  if (isset($_GET['child_id'])) {
    $child = $functions->getThisChild($_GET['child_id']);
    $immunization = $functions->childImmunization($_GET['child_id']);
    $vaccines = $functions->getAvailableVaccine();
    $all_vaccines = $functions->getAllVaccine();

    $c_m_name = $child['c_m_name'];
    $words = explode(' ', $c_m_name);
    if (count($words) > 1) {
      // For two words, get the first letter of each
      $initials = strtoupper(substr($words[0], 0, 1)) . strtoupper(substr($words[1], 0, 1)) . '.';
    } else {
      // For one word, get only the first letter
      $initials = strtoupper(substr($c_m_name, 0, 1)) . '.';
    }
  }

  // get the status of the submitted form (success/error)
  $status = $_GET['status'] ?? '';

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $active_child_list = '';
  // Check if the current page is 'view_child.php'
  if ($current_page == 'child_immunization.php') {

    // means my child menu is active
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
  <title><?php echo $child['c_fname'] . ' ' . $initials . ' ' . $child['c_lname']; ?>'s immunization record
  </title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

  <!-- check if form is submitted successfully -->
  <?php if ($status == 'added_successfully'): ?>
    <script>
      Swal.fire({
        title: "",
        text: "Record added!",
        icon: "success",
        confirmButtonColor: "#009c95"
      });
    </script>
    <!-- check if image is updated -->
  <?php elseif ($status == 'updated'): ?>
    <script>
      Swal.fire({
        title: "",
        text: "Updated!",
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

          <nav class="nav">
            <a href="view_child.php?child_id=<?php echo $child['child_id']; ?>"
              class="nav-link text-secondary small">Profile</a>
            <a href="child_immunization.php?child_id=<?php echo $child['child_id']; ?>"
              class="nav-link text-light bg-main rounded small">Immunization</a>
            <a href="child_findings.php?child_id=<?php echo $child['child_id']; ?>"
              class="nav-link text-secondary small">Findings</a>
          </nav>

          <!-- Content Row -->
          <div class="row my-5 h-100">

            <div class="col-md-12 mb-3 <?php echo $admin_access; ?>">
              <div class="d-flex">
                <button type="button" class="btn btn-sm btn-info d-flex align-items-center mr-2" data-toggle="modal"
                  data-target="#add_immunization">
                  <i class="fas fa-fw fa-plus mr-1"></i>Add new record
                </button>
                <button type="button" class="btn btn-sm btn-main d-flex align-items-center" data-toggle="modal"
                  data-target="#add_past_immunization">
                  <i class="fas fa-fw fa-plus mr-1"></i>Add past record
                </button>
              </div>
            </div>

            <?php include 'modals/add_immunization_modal.php'; ?>
            <?php include 'modals/add_past_immunization_modal.php'; ?>

            <div class="col-md-12">
              <div class="card shadow">
                <div class="card-header py-3">
                  <h6 class="m-0 text-secondary">Immunization record</h6>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <td>Date</td>
                          <td>Vaccine Name</td>
                          <td>Dose</td>
                          <td>Reaction</td>
                          <td>Pediatrician</td>
                          <td class="d-none">Next Appointment</td>
                          <td class="d-none">Next Vaccine</td>
                          <td class="no-export">Action</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($immunization as $row) { ?>
                          <tr>
                            <td><?php
                            // $f_date = date("F j, Y", strtotime($row['date']));
                            // echo $f_date;
                            echo $row['date'];
                            ?></td>
                            <td><?php echo $row['vaccine']; ?></td>
                            <td><?php echo $row['dose']; ?></td>
                            <td><?php echo $row['reaction']; ?></td>
                            <td><?php echo $row['pediatrician']; ?></td>
                            <td class="d-none"><?php echo $row['next_appointment']; ?></td>
                            <td class="d-none"><?php echo $row['next_vaccine']; ?></td>
                            <td class="no-export"><a
                                href="view_immunization.php?immunization_id=<?php echo $row['immunization_id']; ?>"
                                class="btn btn-sm btn-main"><i class="fas fa-fw fa-eye mr-1"></i>View</>
                            </td>
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
            title: 'Immunization Record',
            filename: 'Immunization Record'
          },
          {
            extend: 'pdfHtml5',
            text: 'Export to PDF',
            exportOptions: {
              columns: ':visible:not(:last-child), :hidden'  // Include hidden columns but exclude columns with class "no-export"
            },
            title: 'Immunization Record',
            filename: 'Immunization Record',
            orientation: 'landscape',  // PDF layout (portrait or landscape)
            pageSize: 'A4',  // PDF page size (A4, A5, etc.)
          },
          {
            extend: 'print',
            text: 'Print',
            exportOptions: {
              columns: ':visible:not(:last-child), :hidden'  // Include hidden columns but exclude columns with class "no-export"
            },
            title: 'Immunization Record'
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