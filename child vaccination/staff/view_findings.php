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

  if (isset($_GET['checkup_id'])) {
    $findings = $functions->getFindings($_GET['checkup_id']);
    $child_id = $findings['child_id'];
    $child = $functions->getChildName($child_id);
  }

  // get the status of the submitted form (success/error)
  $status = $_GET['status'] ?? '';

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $active_child_list = '';
  if ($current_page == 'view_findings.php') {
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
  ; ?>'s findings</title>
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
                  href="child_findings.php?child_id=<?php echo $child_id ?>">Findings</a></li>
              <li class="breadcrumb-item active" aria-current="page">View Findings</li>
            </ol>
          </nav>

          <button class="btn btn-sm btn-main shadow-sm mt-3" id="btnprint" onclick="printPage()">
            <i class="fas fa-print fa-sm text-light"></i> Print
          </button>

          <!-- Content Row -->
          <div class="row my-5 d-flex align-items-center h-100">
            <div class="col-md-12 mb-4">
              <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-secondary">Check-up Findings</h6>
                  <div class="dropdown no-arrow <?php echo $admin_access; ?>">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                      aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Action:</div>
                      <button class="dropdown-item" data-toggle="modal" data-target="#edit_findings">Edit</button>
                      <div class="dropdown-divider"></div>
                      <button class="dropdown-item-delete" data-toggle="modal"
                        data-target="#delete_findings">Delete</button>
                    </div>
                  </div>
                </div>

                <?php include 'modals/edit_findings_modal.php'; ?>
                <?php include 'modals/delete_findings_modal.php'; ?>

                <div class="card-body text-center">
                  <div class="row px-4 d-flex align-items-center">
                    <div class="col-md-3">
                      <p class="text-gray small mb-1 mt-3">Weight</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['weight']; ?>" disabled>
                    </div>

                    <div class="col-md-3">
                      <p class="text-gray small mb-1 mt-3">Height</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['height']; ?>" disabled>
                    </div>

                    <div class="col-md-3">
                      <p class="text-gray small mb-1 mt-3">Head circumference</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['head_circumference']; ?>" disabled>
                    </div>

                    <div class="col-md-3">
                      <p class="text-gray small mb-1 mt-3">Chest circumference</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['chest_circumference']; ?>" disabled>
                    </div>

                    <div class="col-md-4">
                      <p class="text-gray small mb-1 mt-3">Developmental milestones</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['developmental_milestones']; ?>" disabled>
                    </div>

                    <div class="col-md-4">
                      <p class="text-gray small mb-1 mt-3">Physical exam</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['physical_exam']; ?>" disabled>
                    </div>

                    <div class="col-md-4">
                      <p class="text-gray small mb-1 mt-3">Immunization status</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['immunization_status']; ?>" disabled>
                    </div>

                    <div class="col-md-4">
                      <p class="text-gray small mb-1 mt-3">Medical history</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['medical_history']; ?>" disabled>
                    </div>

                    <div class="col-md-8">
                      <p class="text-gray small mb-1 mt-3">Assessment recommendations</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['assessment_recommendations']; ?>" disabled>
                    </div>

                    <div class="col-md-12">
                      <p class="text-gray small mb-1 mt-3">Notes</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['notes']; ?>" disabled>
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