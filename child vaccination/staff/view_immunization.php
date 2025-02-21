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

  if (isset($_GET['immunization_id'])) {
    $immunization = $functions->getImmunization($_GET['immunization_id']);
    $child_id = $immunization['child_id'];
    $child = $functions->getChildName($child_id);
    $doctors = $functions->getAllDoctor();
    $all_vaccines = $functions->getAllVaccine();
  }

  // get the status of the submitted form (success/error)
  $status = $_GET['status'] ?? '';

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $active_child_list = '';
  if ($current_page == 'view_immunization.php') {
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
  <title><?php echo $child['c_fname'];
  ; ?>'s immunization</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

  <!-- page loader -->
  <?php include './includes/page_loader.php'; ?>

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
            <ol class="breadcrumb bg-light small shadow nonprint">
              <li class="breadcrumb-item"><a class="text-main"
                  href="child_immunization.php?child_id=<?php echo $child_id ?>">Immunization</a></li>
              <li class="breadcrumb-item active" aria-current="page">View Immunization</li>
            </ol>
          </nav>

          <!-- Page Heading -->
          <!-- <div class="mb-4">
            <h1 class="h3 mb-0 text-gray-800">Page Heading</h1>
          </div> -->

          <button class="btn btn-sm btn-main shadow-sm mt-3" id="btnprint" onclick="printPage()">
            <i class="fas fa-print fa-sm text-light"></i> Print
          </button>

          <!-- Content Row -->
          <div class="row my-5 d-flex align-items-center h-100">
            <div class="col-md-12 mb-4">
              <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 text-secondary">Immunization Info</h6>
                  <div class="dropdown no-arrow <?php echo $admin_access; ?>">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                      aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Action:</div>
                      <button class="dropdown-item" data-toggle="modal" data-target="#edit_immunization">Edit</button>
                      <div class="dropdown-divider"></div>
                      <button class="dropdown-item-delete" data-toggle="modal"
                        data-target="#delete_immunization">Delete</button>
                    </div>
                  </div>
                </div>

                <!-- edit immunization details modal -->
                <?php include 'modals/edit_immunization_modal.php'; ?>

                <!-- delete immunization modal -->
                <?php include 'modals/delete_immunization_modal.php'; ?>

                <div class="card-body text-center">
                  <div class="row px-4 d-flex align-items-center">

                    <?php
                    $info_col = 'col-md-3';
                    $info_col2 = 'col-md-3';
                    if ($immunization['record_type'] == 'past') {
                      $display_record = 'd-none';
                      $info_col = 'col-md-6';
                      $info_col2 = 'col-md-4';
                    }
                    ?>

                    <div class="<?php echo $info_col; ?>">
                      <p class="text-gray small mb-1 mt-3">Vaccine</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $immunization['vaccine']; ?>" disabled>
                    </div>

                    <div class="<?php echo $info_col; ?>">
                      <p class="text-gray small mb-1 mt-3">Dose</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $immunization['dose']; ?>" disabled>
                    </div>

                    <div class="<?php echo $info_col2; ?>">
                      <p class="text-gray small mb-1 mt-3">Pediatrician</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $immunization['pediatrician']; ?>" disabled>
                    </div>

                    <div class="<?php echo $info_col2; ?>">
                      <p class="text-gray small mb-1 mt-3">Reaction</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $immunization['reaction']; ?>" disabled>
                    </div>

                    <div class="col-md-4">
                      <p class=" text-gray small mb-1 mt-3">Date Administered</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php
                        $date_ad = date("l, F j, Y", strtotime($immunization['date']));
                        echo $date_ad;
                        ?>" disabled>
                    </div>

                    <div class="col-md-4 <?php echo $display_record; ?>">
                      <p class="text-gray small mb-1 mt-3">Next Appointment</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php
                        $next_appointment = date("l, F j, Y", strtotime($immunization['next_appointment']));
                        echo $next_appointment;
                        ?>" disabled>
                    </div>

                    <div class="col-md-4 <?php echo $display_record; ?>">
                      <p class="text-gray small mb-1 mt-3">Next Vaccine</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $immunization['next_vaccine']; ?>" disabled>
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

  <script src="./js/print.js"></script>


</body>

</html>