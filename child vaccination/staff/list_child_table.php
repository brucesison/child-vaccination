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
            <h1 class="h3 mb-0 text-gray-800">Child List</h1>
          </div>

          <!-- <button type="button" class="btn btn-sm btn-main d-flex align-items-center" data-toggle="modal"
            data-target="#add_child">
            <i class="fas fa-fw fa-plus mr-1"></i>Add Child
          </button> -->

          <a href="add_child.php" class="btn btn-sm btn-main shadow-sm">
            <i class="fas fa-plus fa-sm mr-1 text-light"></i> Add child
          </a>

          <!-- add parent modal-->
          <?php include './modals/add_child_modal.php'; ?>

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
                          <td>Immunization Status</td>
                          <td>Mother's Name</td>
                          <td>Father's Name</td>
                          <td>Guardian's Name</td>
                          <td class="d-none">Mother's Contact</td>
                          <td class="d-none">Father's Contact</td>
                          <td class="d-none">Guardian's Contact</td>
                          <td class="d-none">Date of Birth</td>
                          <td class="d-none">Time of Birth</td>
                          <td class="d-none">Gender</td>
                          <td class="d-none">Hospital</td>
                          <td class="d-none">Obstretician</td>
                          <td class="d-none">Pediatrician</td>
                          <td class="d-none">Type of Delivery</td>
                          <td class="d-none">Weight</td>
                          <td class="d-none">Height</td>
                          <td class="d-none">Head Circ.</td>
                          <td class="d-none">Chest Circ.</td>
                          <td class="d-none">Apgar</td>
                          <td class="d-none">Blood Type</td>
                          <td class="d-none">Eye Color</td>
                          <td class="d-none">Hair Color</td>
                          <td class="d-none">Marks</td>
                          <td>Action</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $count = 1; ?>
                        <?php foreach ($child as $row) {
                          $c_m_name = $row['c_m_name'];
                          $f_m_name = $row['f_m_name'];
                          $m_m_name = $row['m_m_name'];
                          $g_m_name = $row['g_m_name'];

                          // Split the name into words
                          $words1 = explode(' ', $c_m_name);
                          $words2 = explode(' ', $f_m_name);
                          $words3 = explode(' ', $m_m_name);
                          $words4 = explode(' ', $g_m_name);

                          // Get the first letter of each word and concatenate with a period
                          if (count($words1) > 1 || count($words2) > 1 || count($words3) > 1 || count($words4) > 1) {
                            // For two words, get the first letter of each
                            $initials1 = strtoupper(substr($words1[0], 0, 1)) . strtoupper(substr($words1[1], 0, 1)) . '.';
                            $initials2 = strtoupper(substr($words2[0], 0, 1)) . strtoupper(substr($words2[1], 0, 1)) . '.';
                            $initials3 = strtoupper(substr($words3[0], 0, 1)) . strtoupper(substr($words3[1], 0, 1)) . '.';
                            $initials4 = strtoupper(substr($words4[0], 0, 1)) . strtoupper(substr($words4[1], 0, 1)) . '.';
                          } else {
                            // For one word, get only the first letter
                            $initials1 = strtoupper(substr($c_m_name, 0, 1)) . '.';
                            $initials2 = strtoupper(substr($f_m_name, 0, 1)) . '.';
                            $initials3 = strtoupper(substr($m_m_name, 0, 1)) . '.';
                            $initials4 = strtoupper(substr($g_m_name, 0, 1)) . '.';
                          }
                          ?>
                          <tr>
                            <td><?php echo $count ?></td>
                            <td>
                              <?php echo $row['c_fname'] . ' ' . $initials1 . ' ' . $row['c_lname']; ?>
                            </td>

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

                            <td><?php echo $row['m_fname'] . ' ' . $initials2 . ' ' . $row['m_lname']; ?></td>
                            <td><?php echo $row['f_fname'] . ' ' . $initials3 . ' ' . $row['f_lname']; ?></td>
                            <td><?php echo $row['g_fname'] . ' ' . $initials4 . ' ' . $row['g_lname']; ?></td>
                            <td class="d-none"><?php echo $row['mother_contact']; ?></td>
                            <td class="d-none"><?php echo $row['father_contact']; ?></td>
                            <td class="d-none"><?php echo $row['guardian_contact']; ?></td>
                            <td class="d-none"><?php echo $row['birth_date']; ?></td>
                            <td class="d-none"><?php echo $row['birth_time']; ?></td>
                            <td class="d-none"><?php echo $row['gender']; ?></td>
                            <td class="d-none"><?php echo $row['hospital']; ?></td>
                            <td class="d-none"><?php echo $row['obstretician']; ?></td>
                            <td class="d-none"><?php echo $row['pediatrician']; ?></td>
                            <td class="d-none"><?php echo $row['type_of_delivery']; ?></td>
                            <td class="d-none"><?php echo $row['weight']; ?></td>
                            <td class="d-none"><?php echo $row['height']; ?></td>
                            <td class="d-none"><?php echo $row['head']; ?></td>
                            <td class="d-none"><?php echo $row['chest']; ?></td>
                            <td class="d-none"><?php echo $row['apgar']; ?></td>
                            <td class="d-none"><?php echo $row['blood_type']; ?></td>
                            <td class="d-none"><?php echo $row['eye_color']; ?></td>
                            <td class="d-none"><?php echo $row['hair_color']; ?></td>
                            <td class="d-none"><?php echo $row['marks']; ?></td>
                            <td><a href="view_child.php?child_id=<?php echo $row['child_id']; ?>"
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
            filename: 'Child List'
          },
          {
            extend: 'pdfHtml5',
            text: 'Export to PDF',
            exportOptions: {
              columns: ':visible:not(:last-child), :hidden'  // Include hidden columns but exclude columns with class "no-export"
            },
            title: 'Data Export',
            filename: 'Child List',
            orientation: 'landscape',  // PDF layout (portrait or landscape)
            pageSize: 'A4',  // PDF page size (A4, A5, etc.)
          },
          {
            extend: 'print',
            text: 'Print',
            exportOptions: {
              columns: ':visible:not(:last-child)'  // Include hidden columns but exclude columns with class "no-export"
            },
            title: 'Child List'
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